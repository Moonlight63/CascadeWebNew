<?php
require_once(__DIR__ . "/DataField_Base.php");

class DataField_TextArea extends DataField_Base{
	
	public static $properties = [
		"id", "label", "validation"
	];
	
	public function getHTML($currentValue = ""){
		ob_start();
		?>
		
		<div class="form-group">
			<label for="<?php echo($this->id); ?>"><?php echo($this->label); ?></label>
			<textarea style="max-width: 100%; height: 150px;" name="<?php echo($this->id); ?>" id="<?php echo($this->id); ?>" <?php if(isset($this->tabIndex)){echo("tabindex=$this->tabIndex");} ?> class="form-control"><?php if ($currentValue != ""){ echo((($currentValue))); } ?></textarea>
		</div>

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