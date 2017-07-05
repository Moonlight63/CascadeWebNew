// JavaScript 

(function($){
    
    function getFileInfo( fileURL, callback = function( info ){} ){
        //try{
            $.ajax({
                type: "HEAD",
                async: false,
                url: fileURL,
            }).done(function(message,text,jqXHR){
                callback({"jqXHR": jqXHR});
            }).fail(function(e){
                console.log("Error Grabbing File");
                console.log(e);
                callback({"error": true, "status": e.status, "statusText": e.statusText});
            });
        /*}
        catch(e){
            console.log("Error Grabbing File");
            callback({"error": true});
        }*/
    }
    
    Dropzone.autoDiscover = false;
    
    $(window).load(function(){
        
        var container = $("#grav-dropzone");
        console.log();
        if(container.length){
            var dropzone = Dropzone.forElement('#grav-dropzone');

            if(container.data('editor') == "html"){

                container.on('dragstart', '.dz-preview', function(e){
                    let target = $(e.currentTarget).find('.dz-filename');
                    Dropzone.forElement("#grav-dropzone").disable();
                    target.addClass('hide-backface');
                    
                    getFileInfo(container.data('media-path') + '/' + target.text(), function(data){
                        
                        if ( !data.error ){
                            data.url = container.data('media-path') + '/' + target.text();
                            data.fileName = target.text();
                            data.type = data.jqXHR.getResponseHeader('Content-type');
                        }
                        
                        delete data.jqXHR;
                        
                        console.log(data);
                        
                        e.originalEvent.dataTransfer.effectAllowed = 'copy';
                        e.originalEvent.dataTransfer.setData('text', JSON.stringify(data));
                        
                        /*e.originalEvent.dataTransfer.effectAllowed = 'copy';
                        e.originalEvent.dataTransfer.setData('text', JSON.stringify(data));
                        
                        let obj = {"method": "unset", "url": container.data('media-path') + '/' + target.text(), "fileName": target.text()};

                        if (data.jqXHR.getResponseHeader('Content-type').startsWith("image/")){
                            obj.method = "image.insert";
                        } else {
                            obj.method = "link.insert";
                        }
                        
                        e.originalEvent.dataTransfer.effectAllowed = 'copy';
                        e.originalEvent.dataTransfer.setData('text', JSON.stringify(obj));*/
                    });
                    
                    
                    /*let target = $(e.currentTarget);
                    let uri = encodeURI(target.find('.dz-filename').text());
                    let shortcode = '<img src="' + container.data('media-path') + '/' + uri + '">';
                    Dropzone.forElement("#grav-dropzone").disable();
                    console.log(shortcode);
                    target.addClass('hide-backface');
                    e.originalEvent.dataTransfer.effectAllowed = 'copy';
                    e.originalEvent.dataTransfer.setData('text', shortcode);*/
                });

                container.on('dragend', '.dz-preview', function(e){
                    let target = $(e.currentTarget);
                    Dropzone.forElement("#grav-dropzone").enable();
                    target.removeClass('hide-backface');
                });

                container.on('click', '[data-dz-insert]', function(e){
                    let target = $(e.currentTarget).parent('.dz-preview').find('.dz-filename');
                    console.log(container.data('media-path') + '/' + target.text());
                    getFileInfo(container.data('media-path') + '/' + target.text(), function(data){
                        console.log(data.jqXHR.getResponseHeader('Content-type'));

                        if (data.jqXHR.getResponseHeader('Content-type').startsWith("image/")){
                            console.log("Is Image");
                            $('.froalaEditor').froalaEditor("image.insert", container.data('media-path') + '/' + target.text());
                        }
                    });
                    /*let editor = $('.froalaEditor').froalaEditor;

                    if (editor.length) {
                        editor = editor.data('codemirror');
                        editor.focus();

                        let filename = encodeURI(target.text());
                        let shortcode = UriToMarkdown(filename);
                        editor.doc.replaceSelection(shortcode);
                    }*/
                });

            }
        }
            

    });
    
})(jQuery);