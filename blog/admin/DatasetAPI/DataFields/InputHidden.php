<?php
require_once(__DIR__ . "/DataField_Base.php");

class DataField_HiddenInput extends DataField_Base{
	
	public static $properties = [
		"id", "value", "validation"
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
		
		<input type="hidden" id="<?php echo($this->id); ?>" name="<?php echo($this->id); ?>" value="<?php echo($this->value); ?>" >

		<?php 
		$content = ob_get_contents();
		ob_end_clean();

		return($content);
	}
	
	function getJS($currentValue = ""){
		ob_start();
		?>

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