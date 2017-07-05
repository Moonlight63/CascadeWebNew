<?php
require_once(__DIR__ . "/DataField_Base.php");

class DataField_DropSelect extends DataField_Base{
	
	public static $properties = [
		"id", "label", "options"
	];
	
	public function getHTML($currentValue = ""){
		ob_start();
		?>

		<div class="form-group">
			<label for="<?php echo($this->id); ?>"><?php echo($this->label); ?></label>
			<select class="form-control" id="<?php echo($this->id); ?>" name="<?php echo($this->id); ?>"  >
				<?php foreach($this->options as $key => $value): ?>
				<option value="<?php echo($key);?>" <?php if ($currentValue == $key){ echo("selected=\"selected\""); } ?> ><?php echo($value); ?></option>
				<?php endforeach ?>
			</select>
		</div>

		<?php 
		$content = ob_get_contents();
		ob_end_clean();

		return($content);
	}
	
	public function validate($passedValue){
		return([]);
	}
	
}

?>