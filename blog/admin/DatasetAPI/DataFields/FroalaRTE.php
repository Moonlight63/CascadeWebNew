<?php
require_once(__DIR__ . "/DataField_Base.php");

class DataField_FroalaRTE extends DataField_Base{
	
	public static $properties = [
		"id", "label", "directory", "dropzoneID", "validation"
	];
	
	public function getIncludes(){
		ob_start();

		$includesForRTE = [
			"https://cdnjs.cloudflare.com/ajax/libs/froala-editor/2.5.0/css/froala_editor.css",
			"https://cdnjs.cloudflare.com/ajax/libs/froala-editor/2.5.0/css/froala_style.css",
			"https://cdnjs.cloudflare.com/ajax/libs/froala-editor/2.5.0/js/froala_editor.min.js",

			"https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.3.0/codemirror.min.css",
			"https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.3.0/codemirror.min.js",
			"https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.3.0/mode/xml/xml.min.js",

			"https://cdnjs.cloudflare.com/ajax/libs/froala-editor/2.5.0/js/plugins/align.min.js",

			"https://cdnjs.cloudflare.com/ajax/libs/froala-editor/2.5.0/css/plugins/char_counter.min.css",
			"https://cdnjs.cloudflare.com/ajax/libs/froala-editor/2.5.0/js/plugins/char_counter.min.js",

			"https://cdnjs.cloudflare.com/ajax/libs/froala-editor/2.5.0/css/plugins/code_view.min.css",
			"https://cdnjs.cloudflare.com/ajax/libs/froala-editor/2.5.0/js/plugins/code_view.min.js",

			"https://cdnjs.cloudflare.com/ajax/libs/froala-editor/2.5.0/js/plugins/code_beautifier.min.js",

			"https://cdnjs.cloudflare.com/ajax/libs/froala-editor/2.5.0/css/plugins/colors.min.css",
			"https://cdnjs.cloudflare.com/ajax/libs/froala-editor/2.5.0/js/plugins/colors.min.js",

			"https://cdnjs.cloudflare.com/ajax/libs/froala-editor/2.5.0/css/plugins/draggable.min.css",
			"https://cdnjs.cloudflare.com/ajax/libs/froala-editor/2.5.0/js/plugins/draggable.min.js",

			//"https://cdnjs.cloudflare.com/ajax/libs/froala-editor/2.5.0/js/plugins/entities.min.js",

			"https://cdnjs.cloudflare.com/ajax/libs/froala-editor/2.5.0/css/plugins/file.min.css",
			"https://cdnjs.cloudflare.com/ajax/libs/froala-editor/2.5.0/js/plugins/file.min.js",

			/*"https://cdnjs.cloudflare.com/ajax/libs/froala-editor/2.5.0/js/plugins/font_family.min.js",*/
			/*"https://cdnjs.cloudflare.com/ajax/libs/froala-editor/2.5.0/js/plugins/font_size.min.js",*/

			"https://cdnjs.cloudflare.com/ajax/libs/froala-editor/2.5.0/css/plugins/fullscreen.min.css",
			"https://cdnjs.cloudflare.com/ajax/libs/froala-editor/2.5.0/js/plugins/fullscreen.min.js",

			"https://cdnjs.cloudflare.com/ajax/libs/froala-editor/2.5.0/css/plugins/help.min.css",
			"https://cdnjs.cloudflare.com/ajax/libs/froala-editor/2.5.0/js/plugins/help.min.js",

			"https://cdnjs.cloudflare.com/ajax/libs/froala-editor/2.5.0/css/plugins/image.min.css",
			"https://cdnjs.cloudflare.com/ajax/libs/froala-editor/2.5.0/js/plugins/image.min.js",

			/*"https://cdnjs.cloudflare.com/ajax/libs/froala-editor/2.5.0/css/plugins/image_manager.min.css",*/
			/*"https://cdnjs.cloudflare.com/ajax/libs/froala-editor/2.5.0/js/plugins/image_manager.min.js",*/

			"https://cdnjs.cloudflare.com/ajax/libs/froala-editor/2.5.0/css/plugins/line_breaker.min.css",
			"https://cdnjs.cloudflare.com/ajax/libs/froala-editor/2.5.0/js/plugins/line_breaker.min.js",

			"https://cdnjs.cloudflare.com/ajax/libs/froala-editor/2.5.0/js/plugins/link.min.js",

			"https://cdnjs.cloudflare.com/ajax/libs/froala-editor/2.5.0/js/plugins/lists.min.js",

			/*"https://cdnjs.cloudflare.com/ajax/libs/froala-editor/2.5.0/js/plugins/paragraph_format.min.js",*/
			/*"https://cdnjs.cloudflare.com/ajax/libs/froala-editor/2.5.0/js/plugins/paragraph_style.min.js",*/

			"https://cdnjs.cloudflare.com/ajax/libs/froala-editor/2.5.0/js/plugins/print.min.js",

			"https://cdnjs.cloudflare.com/ajax/libs/froala-editor/2.5.0/css/plugins/quick_insert.min.css",
			"https://cdnjs.cloudflare.com/ajax/libs/froala-editor/2.5.0/js/plugins/quick_insert.min.js",

			"https://cdnjs.cloudflare.com/ajax/libs/froala-editor/2.5.0/js/plugins/quote.min.js",

			"https://cdnjs.cloudflare.com/ajax/libs/froala-editor/2.5.0/js/plugins/save.min.js",

			"https://cdnjs.cloudflare.com/ajax/libs/froala-editor/2.5.0/css/plugins/special_characters.min.css",
			"https://cdnjs.cloudflare.com/ajax/libs/froala-editor/2.5.0/js/plugins/special_characters.min.js",

			"https://cdnjs.cloudflare.com/ajax/libs/froala-editor/2.5.0/css/plugins/table.min.css",
			"https://cdnjs.cloudflare.com/ajax/libs/froala-editor/2.5.0/js/plugins/table.min.js",

			"https://cdnjs.cloudflare.com/ajax/libs/froala-editor/2.5.0/js/plugins/url.min.js",

			"https://cdnjs.cloudflare.com/ajax/libs/froala-editor/2.5.0/css/plugins/video.min.css",
			"https://cdnjs.cloudflare.com/ajax/libs/froala-editor/2.5.0/js/plugins/video.min.js",

			"https://cdnjs.cloudflare.com/ajax/libs/froala-editor/2.5.0/js/plugins/word_paste.min.js"
		];


		foreach($includesForRTE as $include){
			if( (substr($include, -strlen(".css")) === ".css") ){
				echo("<link href='{$include}' rel='stylesheet' type='text/css' />");
			}elseif( (substr($include, -strlen(".js")) === ".js") ){
				echo("<script type='text/javascript' src='{$include}'></script>");
			}
		}
		
		$content = ob_get_contents();
		ob_end_clean();

		return($content);
	}
	
	public function getHTML($currentValue = ""){
		ob_start();
		?>
		
		<div id="<?php echo($this->id); ?>CurrentData" style="display: none">
			<?php if ($currentValue != ""){ echo((($currentValue))); } ?>
		</div>
		
		<div class="form-group">
			<label for="<?php echo($this->id); ?>"><?php echo($this->label); ?></label>
			<textarea name="<?php echo($this->id); ?>" id="<?php echo($this->id); ?>" class="form-control" <?php if(isset($this->tabIndex)){echo("tabindex=$this->tabIndex");} ?> ></textarea>
		</div>

		<?php 
		$content = ob_get_contents();
		ob_end_clean();

		return($content);
	}
	
	function getJS($currentValue = ""){
		ob_start();
		?>

		<script>
	
			$('#<?php echo($this->id); ?>').froalaEditor({
				imageUploadURL: "<?php echo(self::getPathToIncludes())?>/dropzone/file_ops.php",
				imageUploadParams: {reqType: 'imgUpload', folder: "<?php echo($this->directory);?>"},
				imageResizeWithPercent: true,
				toolbarSticky: true,
				htmlUntouched: true,
				heightMin: 400
			})
			.on('froalaEditor.drop', function (e, editor, dropEvent) {
				
				editor.markers.insertAtPoint(dropEvent.originalEvent);
				var $marker = editor.$el.find('.fr-marker');
				$marker.replaceWith($.FroalaEditor.MARKERS);
				editor.selection.restore();

				if (!editor.undo.canDo()) editor.undo.saveStep();

				try{
					var imgURL = JSON.parse(dropEvent.originalEvent.dataTransfer.getData("Text")).imageURL;
					if (imgURL != null) {
						var html = '<img src="' + imgURL + '" />';
						editor.html.insert(html, true);
						editor.undo.saveStep();
						dropEvent.preventDefault();
						dropEvent.stopPropagation();
						return false;
					}
				} catch (e){

				}
				editor.undo.saveStep();

			})
			<?php if($this->dropzoneID != null && $this->dropzoneID != ""){ ?>
				
			.on('froalaEditor.image.uploaded', function (e, editor, response) {
				var dz = Dropzone.forElement("div#<?php echo($this->dropzoneID); ?>");
				response = JSON.parse(response);
				var mockFile = { name: response.name, size: response.fileSize, type: response.mime, url: response.link };

				dz.emit("addedfile", mockFile);
				dz.emit("thumbnail", mockFile, response.thumb);
				dz.emit("complete", mockFile);
				dz.files.push(mockFile);
			})
				
			<?php } ?>
			;
			
			$('#<?php echo($this->id); ?>').froalaEditor('html.insert', $("#<?php echo($this->id); ?>CurrentData").html(), true);
			$("#<?php echo($this->id); ?>CurrentData").remove();
			
			$(window).load(function(){setTimeout(function(){
				var licheck = $(".fr-basic").find(":contains('Unlicensed Froala Editor')").remove();
				console.log(licheck);
			}, 100)});
			
		</script>

		<?php 
		$content = ob_get_contents();
		ob_end_clean();

		return($content);
	}
	
	
	public function validate($passedValue){
		$result = [];
		$valid = function($type, $value, $that){
			if($type == "required"){
				if(!isset($value) || $value == ""){
					return "{$that->label} is Required!";
				}
			}
		};
		
		if(!(!$this->validation)){
			if(is_array($this->validation)){
				foreach($this->validation as $type){
					$result[] = $valid($type, $passedValue, $this);
				}
			}else{
				$result[] = $valid($this->validation, $passedValue, $this);
			}
		}
		return($result);
	}
	
}

?>