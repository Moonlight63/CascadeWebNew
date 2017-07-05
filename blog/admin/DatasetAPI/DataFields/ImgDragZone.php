<?php
require_once(__DIR__ . "/DataField_Base.php");

class DataField_ImgDragZone extends DataField_Base{
	
	public static $properties = [
		"id", "label", "validation"
	];
	
	public function getIncludes(){
		ob_start();
		?>

		<?php 
		$content = ob_get_contents();
		ob_end_clean();

		return($content);
	}
	
	public function getHTML($currentValue = ""){
		ob_start();
		?>
		
		<div class="form-group">
			<label><?php echo($this->label); ?></label>
			<div id="<?php echo($this->id); ?>Cont" style="border: 2px dashed #bdbdbd; margin: 0 auto 0 auto; min-height: 150px;">
				<img id="<?php echo($this->id); ?>Img" style="width: 100%; height: auto;" <?php if ($currentValue != ""){ echo("src=\"{$currentValue}\""); } ?> />
			</div>
			<input type="hidden" name="<?php echo($this->id); ?>" id="<?php echo($this->id); ?>" value="">
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
			$("#<?php echo($this->id); ?>").val($("#<?php echo($this->id); ?>Img").attr("src"));
			
			$("#<?php echo($this->id); ?>Cont").on("dragover", function(e){e.preventDefault();e.stopPropagation();}).on("drop", function(e){
				// Insert HTML.
				try{
					var imgURL = JSON.parse(e.originalEvent.dataTransfer.getData("Text")).imageURL;
					if (imgURL != null) {
						if($(this).find("img").length == 0){
							$(this).append("<img id='<?php echo($this->id); ?>' style='width: 100%; height: auto;' />");
						}
						$(this).find("img").attr("src", imgURL);
						
						$("#<?php echo($this->id); ?>").val($("#<?php echo($this->id); ?>Img").attr("src"));
						// Stop event propagation.
						e.preventDefault();
						e.stopPropagation();
						return false;
					}
				} catch (e){}

			});
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