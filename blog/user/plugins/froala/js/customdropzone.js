// JavaScript 

(function($){
    
    function getFileInfo( fileURL, callback = function( info ){} ){
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
    }
    
    Dropzone.autoDiscover = false;
    
    $(window).load(function(){
        
        var container = $("#grav-dropzone");
        
        if(container.length){
            var dropzone = Dropzone.forElement('#grav-dropzone');

            if(container.data('editor') == "html"){

                container.on('dragstart', '.dz-preview', function(e){
                    let target = $(e.currentTarget).find('.dz-filename');
                    Dropzone.forElement("#grav-dropzone").disable();
                    target.addClass('hide-backface');
                    
                    getFileInfo(container.data('media-path') + '/' + target.text(), function(data){
                        
                        if ( !data.error ){
                            data.url = container.data( 'media-path' ) + '/' + target.text();
                            data.fileName = target.text();
                            data.type = data.jqXHR.getResponseHeader( 'Content-type' );
                        }
                        
                        delete data.jqXHR;
                        
                        e.originalEvent.dataTransfer.effectAllowed = 'copy';
                        e.originalEvent.dataTransfer.setData('text', JSON.stringify(data));
                        
                    });
                });

                container.on('dragend', '.dz-preview', function(e){
                    let target = $(e.currentTarget);
                    Dropzone.forElement("#grav-dropzone").enable();
                    target.removeClass('hide-backface');
                });

                container.on('click', '[data-dz-insert]', function(e){
                    let target = $(e.currentTarget).parent('.dz-preview').find('.dz-filename');
                    getFileInfo(container.data('media-path') + '/' + target.text(), function(data){
                        
                        if ( !data.error ){
                            data.url = container.data('media-path') + '/' + target.text();
                            data.fileName = target.text();
                            data.type = data.jqXHR.getResponseHeader('Content-type');
                        }
                        
                        delete data.jqXHR;
                        
                        $('.froalaEditor').froalaEditor("addFromDrop.insert", JSON.stringify(data));
                        
                    });
                });

            }
        }
            

    });
    
})(jQuery);