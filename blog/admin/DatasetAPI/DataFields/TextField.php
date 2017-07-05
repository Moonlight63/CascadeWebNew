<?php
require_once(__DIR__ . "/DataField_Base.php");

class DataField_TextField extends DataField_Base{
	
	public static $properties = [
		"id", "label", "placeHolder", "validation"
	];
	
	public function getHTML($currentValue = ""){
		ob_start();
		?>

		<div class="form-group">
			<label for="<?php echo($this->id); ?>"><?php echo($this->label); ?></label>
			<input type="text" class="form-control" id="<?php echo($this->id); ?>" name="<?php echo($this->id); ?>" placeholder="<?php echo($this->placeHolder); ?>" <?php if ($currentValue != ""){ echo("value=\"{$currentValue}\""); } ?> <?php if(isset($this->tabIndex)){echo("tabindex=$this->tabIndex");} ?> >
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
			else if ($type == "nospace"){
				if(!isset($value) || preg_match('/\s/', $value)){
					return "{$that->label} is must not contain any whitespace!";
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