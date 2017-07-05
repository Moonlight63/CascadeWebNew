// JavaScript Document
(function(){
    
    var mimeGuess = function (url) {
		var mimes = {
			'mp3': 'audio/mpeg',
			'wav': 'audio/wav',
			'mp4': 'video/mp4',
			'webm': 'video/webm',
			'ogg': 'video/ogg',
			'swf': 'application/x-shockwave-flash'
		};
		var fileEnd = url.toLowerCase().split('.').pop();
		var mime = mimes[fileEnd];

		return mime ? mime : '';
	};
    
    var urlPatterns = [
		{
			regex: /youtu\.be\/([\w\-.]+)/,
			type: 'iframe', w: 560, h: 314,
			url: '//www.youtube.com/embed/$1',
			allowFullscreen: true
		},
		{
			regex: /youtube\.com(.+)v=([^&]+)/,
			type: 'iframe', w: 560, h: 314,
			url: '//www.youtube.com/embed/$2',
			allowFullscreen: true
		},
		{
			regex: /youtube.com\/embed\/([a-z0-9\-_]+(?:\?.+)?)/i,
			type: 'iframe', w: 560, h: 314,
			url: '//www.youtube.com/embed/$1',
			allowFullscreen: true
		},
		{
			regex: /vimeo\.com\/([0-9]+)/,
			type: 'iframe', w: 425, h: 350,
			url: '//player.vimeo.com/video/$1?title=0&byline=0&portrait=0&color=8dc7dc',
			allowfullscreen: true
		},
		{
			regex: /vimeo\.com\/(.*)\/([0-9]+)/,
			type: "iframe", w: 425, h: 350,
			url: "//player.vimeo.com/video/$2?title=0&amp;byline=0",
			allowfullscreen: true
		},
		{
			regex: /maps\.google\.([a-z]{2,3})\/maps\/(.+)msid=(.+)/,
			type: 'iframe', w: 425, h: 350,
			url: '//maps.google.com/maps/ms?msid=$2&output=embed"',
			allowFullscreen: false
		},
		{
			regex: /dailymotion\.com\/video\/([^_]+)/,
			type: 'iframe', w: 480, h: 270,
			url: '//www.dailymotion.com/embed/video/$1',
			allowFullscreen: true
		}/*,
        {
			regex: /soundcloud\.com\/([^_]+)/,
			type: 'iframe', w: 480, h: 270,
			url: '//www.dailymotion.com/embed/video/$1',
			allowFullscreen: true
		}*/
	];
    
    var dataToHtml = function (editor, dataIn) {
		var html = '';
		var data = dataIn;

		if (!data.source1) {
            return '';
		}

		if (!data.source2) {
			data.source2 = '';
		}

		if (!data.poster) {
			data.poster = '';
		}

		data.source1 = editor.convertURL(data.source1, "source");
		data.source2 = editor.convertURL(data.source2, "source");
		data.source1mime = mimeGuess(data.source1);
		data.source2mime = mimeGuess(data.source2);
		data.poster = editor.convertURL(data.poster, "poster");

		tinymce.util.Tools.each(urlPatterns, function (pattern) {
			var i;
			var url;

			var match = pattern.regex.exec(data.source1);

			if (match) {
				url = pattern.url;

				for (i = 0; match[i]; i++) {
					url = url.replace('$' + i, function () {
						return match[i];
					});
				}

				data.source1 = url;
				data.type = pattern.type;
				data.allowFullscreen = pattern.allowFullscreen;
				data.width = data.width || pattern.w;
				data.height = data.height || pattern.h;
			}
		});
        
        

        data.width = data.width || 300;
        data.height = data.height || 150;

        tinymce.util.Tools.each(data, function (value, key) {
            data[key] = editor.dom.encode(value);
        });
        
        

        if (data.type === "iframe") {
            var allowFullscreen = data.allowFullscreen ? ' allowFullscreen="1"' : '';
            html +=
                '<div class="responsEmbedContainer" data-responsive-embed style="display: block; width: ' + data.width + '">' +
                '<div style="height: 0; position: relative; padding-bottom: ' + data.height + ';">' +
                '<iframe src="' + data.source1 + '" style="position: absolute; border: 0;" width="100%" height="100%"' + allowFullscreen + '></iframe>' +
                '</div> </div>';
        } else if (data.source1mime.indexOf('audio') !== -1) {
            if (editor.settings.audio_template_callback) {
                html = editor.settings.audio_template_callback(data);
            } else {
                html += (
                    '<audio controls="controls" src="' + data.source1 + '">' +
                        (
                            data.source2 ?
                                '\n<source src="' + data.source2 + '"' +
                                    (data.source2mime ? ' type="' + data.source2mime + '"' : '') +
                                ' />\n' : '') +
                    '</audio>'
                );
            }
        } else {
            if (editor.settings.video_template_callback) {
                html = editor.settings.video_template_callback(data);
            } else {
                html = (
                    '<video width="' + data.width +
                        '" height="' + data.height + '"' +
                            (data.poster ? ' poster="' + data.poster + '"' : '') + ' controls="controls">\n' +
                        '<source src="' + data.source1 + '"' +
                            (data.source1mime ? ' type="' + data.source1mime + '"' : '') + ' />\n' +
                        (data.source2 ? '<source src="' + data.source2 + '"' +
                            (data.source2mime ? ' type="' + data.source2mime + '"' : '') + ' />\n' : '') +
                    '</video>'
                );
            }
        }

		return html;
	};
    
    var handleInsert = function (editor, html) {
		editor.insertContent(html);
		editor.nodeChanged();
	};

	var submitForm = function (win, editor) {
		var data = win.toJSON();
        console.log(data);
        
        var response = dataToHtml(editor, data);
        handleInsert(editor, response);
	};
    
    
    var jsonFromStyle = function(stylestring){
        var parts = stylestring.split(";");
        var obj = {}
        for ( var i = 0; i < parts.length; i++ ) {
            var subParts = parts[i].split(':');
            if(subParts[0] == "") continue;
            obj[subParts[0].trim()] = subParts.splice(1, subParts.length).join(":").trim();
        }
        return obj;
    }
    
    var getData = function (editor) {
		var element = editor.selection.getNode();
        
        if(!element.getAttribute('data-mce-object')){
            return {};
        }
        
        var source = element.firstChild.firstChild.firstChild.src;
        var width = jsonFromStyle((JSON.parse(element.firstChild.dataset.origAttribs).style)).width;
        var height = jsonFromStyle((JSON.parse(element.firstChild.firstChild.dataset.origAttribs).style))["padding-bottom"];
        
        var returnOBJ = {
            source1: source,
            width: width,
            height: height
        }
        console.log(returnOBJ);
        return returnOBJ;
        
	};
    
    
    var embedDialog = function (editor) {
		var win;
		var data;

		var generalFormItems = [{
            name: 'source1',
            type: 'filepicker',
            filetype: 'media',
            size: 40,
            autofocus: true,
            label: 'Source',
            onbeforecall: function (e) {
                e.meta = win.toJSON();
            }
        },{
            type: 'container',
            label: 'Dimensions',
            layout: 'flex',
            align: 'center',
            spacing: 5,
            items: [{
                name: 'width',
                type: 'textbox',
                maxLength: 5,
                size: 5,
                ariaLabel: 'Width'
            },
            {type: 'label', text: 'x'},
            {
                name: 'height',
                type: 'textbox',
                maxLength: 5,
                size: 5,
                ariaLabel: 'Height'
            }]
        }];
        

		var advancedFormItems = [];
        
        advancedFormItems.push({name: 'source2', type: 'filepicker', filetype: 'media', size: 40, label: 'Alternative source'});
        advancedFormItems.push({name: 'poster', type: 'filepicker', filetype: 'image', size: 40, label: 'Poster'});

		data = getData(editor);

		win = editor.windowManager.open({
			title: 'Insert/edit responsive media',
			data: data,
			bodyType: 'tabpanel',
			body: [
				{
					title: 'General',
					type: "form",
					items: generalFormItems
				},
				{
					title: 'Advanced',
					type: "form",
					items: advancedFormItems
				}
			],
			onSubmit: function () {
				submitForm(win, editor);
			}
		});

	};
    
    
    function Nodes () {
        
        var Env = tinymce.Env;
        var Node = tinymce.html.Node;
        
        function createPreviewHtml(node){
            var previewNode = new Node(node.name, 1);
            var previewattributes = {};
            var a = node.attributes.length;
            
            while(a--){
                previewattributes[node.attributes[a].name] = node.attributes[a].value;
            }
            
            previewNode.attr(previewattributes);
            previewNode.attr("data-orig-attribs", JSON.stringify(previewattributes));
            
            if(previewNode.attr("class") == "responsEmbedContainer"){
                previewNode.attr("style", previewNode.attr("style") + " width: 100%;");
            }
            if(previewNode.name == "iframe"){
                previewNode.attr("style", previewNode.attr("style") + " border: 0;");
            }
            console.log(previewNode.attributes);
            
            if(node.firstChild){
                previewNode.append(createPreviewHtml(node.firstChild));
            }
            
            return previewNode;
        }
        
        function reversePreviewHtml(node){
            var htmlNode = new Node(node.name, 1);
            
            console.log(node.attr("data-orig-attribs"));
            if(node.attr("data-orig-attribs") !== undefined){
                htmlNode.attr(JSON.parse(node.attr("data-orig-attribs")));
            }
            
            
            if(node.firstChild){
                htmlNode.append(reversePreviewHtml(node.firstChild));
            }
            
            return htmlNode;
        }
        
        var createPreviewDivNode = function (editor, node) {
            var previewWrapper;
            var previewNode;
            var shimNode;
            var name = node.name;
            var nodeCopy = node;

            previewWrapper = new Node('span', 1);
            previewWrapper.attr({
                contentEditable: 'false',
                style: node.attr('style'),
                "data-mce-object": name,
                "class": "mce-preview-object mce-object-" + name
            });

            shimNode = new Node('span', 1);
            shimNode.attr('class', 'mce-shim');
            
            previewWrapper.append(createPreviewHtml(node));
            previewWrapper.append(shimNode);
            

            return previewWrapper;
        };

        var placeHolderConverter = function (editor) {
            return function (nodes) {
                var i = nodes.length;
                var node;
                var videoScript;

                while (i--) {
                    
                    node = nodes[i];
                    if (!node.parent) {
                        continue;
                    }

                    if (node.parent.attr('data-mce-object')) {
                        continue;
                    }

                    if(node.name === 'div'){
                        var a = node.attributes.length;
                        while(a--){
                            if(node.attributes[a].name == 'class' && node.attributes[a].value == 'responsEmbedContainer'){
                                var nodeCopy = node;
                                var previewNode = createPreviewDivNode(editor, node);
                                node.replace(previewNode);
                            }
                        }
                    }
                    
                }
            };
        };

        return {
            placeHolderConverter: placeHolderConverter,
            createPreviewHtml: createPreviewHtml,
            reversePreviewHtml: reversePreviewHtml
        };
    }
    
    
    tinymce.PluginManager.add('videoembed', function(editor, url) {
      // Add a button that opens a window
        console.log(url);
        
        this.showDialog = function () {
			embedDialog(editor);
		};
        
        
        editor.on('preInit', function () {
            // Converts iframe, video etc into placeholder images
			editor.parser.addAttributeFilter('data-responsive-embed', Nodes().placeHolderConverter(editor));
            
            // Replaces placeholder images with real elements for video, object, iframe etc
			//editor.serializer.addAttributeFilter('data-mce-object', function (nodes, name) {
            editor.serializer.addAttributeFilter('data-responsive-embed', function (nodes, name) {    
				var i = nodes.length;
				var node;
				var realElm;
				var ai;
				var attribs;
				var innerHtml;
				var innerNode;
				var realElmName;
				var className;

				while (i--) {
					node = nodes[i];
					if (!node.parent) {
						continue;
					}

					realElmName = node.attr(name);
                    realElm = Nodes().reversePreviewHtml(node);
                    
					node.replace(realElm);
				}
			});
            
		});
        
        editor.on('click keyup', function () {
			var selectedNode = editor.selection.getNode();
            console.log(selectedNode);
			if (selectedNode && editor.dom.hasClass(selectedNode, 'mce-preview-object')) {
				if (editor.dom.getAttrib(selectedNode, 'data-mce-selected')) {
					selectedNode.setAttribute('data-mce-selected', '2');
				}
			}
		});
        
        editor.on('setContent', function () {
			// TODO: This shouldn't be needed there should be a way to mark bogus
			// elements so they are never removed except external save
			editor.$('span.mce-preview-object').each(function (index, elm) {
				var $elm = editor.$(elm);

				if ($elm.find('span.mce-shim', elm).length === 0) {
					$elm.append('<span class="mce-shim"></span>');
				}
			});
		});
        
        
        
        editor.addButton('videoembed', {
            icon: 'media',
			tooltip: 'Insert/edit responsive media',
			onclick: this.showDialog,
			stateSelector: ['img[data-mce-object]', 'span[data-mce-object]', 'div[data-ephox-embed-iri]']
		});

		editor.addMenuItem('videoembed', {
			icon: 'media',
			text: 'Responsive Media',
			onclick: this.showDialog,
			context: 'insert',
			prependToContext: true
		});

        editor.addCommand('mceResponseMedia', this.showDialog);
    });
    
})();