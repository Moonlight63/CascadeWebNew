// JavaScript Document

(function($){
    
    $(window).load(function(){
        
        tinymce.init({ 
            selector:'div.grav-editor-content > textarea.tinymceEditor',
            relative_urls : false,
            live_embeds: false,
            toolbar: "undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | " +
            "bullist numlist outdent indent | link image videoembed",
            /*toolbar: 'example videoembed media',*/
            plugins: [
                'advlist autoresize autolink lists link image charmap print preview hr anchor',
                'pagebreak searchreplace  wordcount visualblocks visualchars code fullscreen',
                'insertdatetime nonbreaking save table contextmenu directionality',
                'emoticons template paste textcolor colorpicker textpattern imagetools codesample toc',
                'videoembed'
            ],
            image_advtab: true,
            image_class_list: [
                {title: 'Responsive', value: 'img-responsive'}
            ],
            media_url_resolver: function (data, resolve/*, reject*/) {
                console.log(data);
                
                var embedHtml = '<iframe src="' + data.url +
                  '" width="400" height="400" ></iframe>';
                resolve({html: embedHtml});
                
            },
            autoresize_bottom_margin: 50
            
        });
        
        $(tinymce.editors).each(function(){
            var that = this;
            console.log(this.getBody());
            console.log($(this.getBody()));
            $(this.getBody()).on('click', function(){
                console.log("Test");
            });
            $(this.getBody()).on('drop', function(e){
                console.log(this);
                e.preventDefault();
                e.stopPropagation();
                that.insertContent(e.originalEvent.dataTransfer.getData('text'));
                console.log(e.originalEvent.dataTransfer.getData('text'));
                return false;
            });
        });        

    });
    
})(jQuery);