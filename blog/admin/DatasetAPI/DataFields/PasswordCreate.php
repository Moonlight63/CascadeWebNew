<?php
require_once(__DIR__ . "/DataField_Base.php");

class DataField_PasswordCreate extends DataField_Base{
	
	public static $properties = [
		"id", "label1", "label2", "placeHolder1", "placeHolder2", "validation"
	];
	
	public function getHTML($currentValue = ""){
		ob_start();
		?>
		
		<div class="form-group">
			<label for="<?php echo($this->id); ?>"><?php echo($this->label1); ?></label>
			<input type="password" name="<?php echo($this->id); ?>" id="<?php echo($this->id); ?>" class="form-control" placeholder="<?php echo($this->placeHolder1); ?>" <?php if(isset($this->tabIndex)){echo("tabindex=$this->tabIndex");} ?> >
		</div>
		<div class="form-group">
			<label for="<?php echo($this->id); ?>_Conf"><?php echo($this->label2); ?></label>
			<input type="password" name="<?php echo($this->id); ?>_Conf" id="<?php echo($this->id); ?>_Conf" class="form-control" placeholder="<?php echo($this->placeHolder2); ?>" <?php if(isset($this->tabIndex)){$tmpindex = $this->tabIndex+1; echo("tabindex=$tmpindex");} ?> >
		</div>

		<?php 
		$content = ob_get_contents();
		ob_end_clean();

		return($content);
	}
	
	public function validate($passedValue, $otherValues, $oldData){
		$result = [];
		$valid = function($type, $value, $that) use ($oldData){
			if($type == "required" && $oldData == "") {
				if(!isset($value) || $value == ""){
					return "{$that->label1} is Required!";
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
		
		if(isset($passedValue) && $passedValue != ""){
			if(isset($otherValues["{$this->id}_Conf"])){
				$conf = $otherValues["{$this->id}_Conf"];
				if ($conf == "") {
					$result[] = "{$this->label2} is Required!";
				} else if ($passedValue !== $conf) {
					$result[] = "{$this->label2} doesn't match {$this->label1}!";
				}
			} else {
				$result[] = "{$this->label1} Confirmation not found!";
			}
		}
		return($result);
	}
	
	public function postProccessValue($value, $oldValue = null){
		if($value == ""){
			return $oldValue;
		}
		return md5($value);
	}
	
}

?>