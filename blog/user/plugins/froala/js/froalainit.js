// JavaScript Document

(function ($) {
    
    $.FroalaEditor.PLUGINS.addFromDrop = function (editor) {

        function insert (data) {

            if (!editor.undo.canDo()) editor.undo.saveStep();

            try{
                var data = JSON.parse(data);
                
                if ( data.error ) {
                    editor.html.insert( "Error Grabbing File: " + data.status + " " + data.statusText );
                    editor.undo.saveStep();
                    return false;
                }
                
                if (data.type.startsWith("image/")){
                    editor.image.insert(data.url);
                } else {
                    editor.link.insert(data.url, data.fileName);
                }
                
                editor.undo.saveStep();
                return true;
            } catch (e){
                console.error(e);
                return false;
            }
            
        }

        function _init () {
            
        }
        
        return {
            _init: _init,
            insert: insert
        }
        
    }
    
})(jQuery);

(function($){
    
    $(window).load(function(){
        
        $('.froalaEditor').froalaEditor({
            
            imageResizeWithPercent: true,
            imageInsertButtons: ['imageByURL'],
            videoInsertButtons: ['videoByURL'],
            videoDefaultWidth: '100%',
            videoResize: false,
            toolbarSticky: false,
            htmlUntouched: false,
            heightMin: 200,
            heightMax: ($(window).innerHeight()-200)
            
        }).on('froalaEditor.drop', function (e, editor, dropEvent) {
            
            editor.markers.insertAtPoint(dropEvent.originalEvent);
            var $marker = editor.$el.find('.fr-marker');
            $marker.replaceWith($.FroalaEditor.MARKERS);
            editor.selection.restore();
            
            editor.addFromDrop.insert(dropEvent.originalEvent.dataTransfer.getData('text'));
            
            dropEvent.preventDefault();
            dropEvent.stopPropagation();
            return false;

        });

        setTimeout(function(){
            var licheck = $(".fr-basic").find(":contains('Unlicensed Froala Editor')").remove();
            console.log(licheck);
        }, 100);
        
    });
    
})(jQuery);