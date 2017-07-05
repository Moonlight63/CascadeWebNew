<?php
require_once(__DIR__ . "/DataField_Base.php");

class DataField_DateField extends DataField_Base{
	
	public static $properties = [
		"id", "label", "minDate", "maxDate", "validation"
	];
	
	public function getIncludes(){
		ob_start();
		?>
		
		<script src="<?php echo(self::getPathToIncludes())?>/datetimepicker/moment.js" type='text/javascript'></script>
		<script src="<?php echo(self::getPathToIncludes())?>/datetimepicker/moment-timezone-with-data.js" type='text/javascript'></script>
		<script src="<?php echo(self::getPathToIncludes())?>/datetimepicker/bootstrap-datetimepicker.js" type='text/javascript'></script>
		<link href="<?php echo(self::getPathToIncludes())?>/datetimepicker/bootstrap-datetimepicker.css" rel="stylesheet" />
		
		<?php 
		$content = ob_get_contents();
		ob_end_clean();

		return($content);
	}
	
	public function getHTML($currentValue = ""){
		ob_start();
		?>
		
		<div class="form-group">
			<label for="<?php echo($this->id); ?>"><?php echo($this->label); ?></label>
			<input type="text" class="form-control" id="<?php echo($this->id); ?>" name="<?php echo($this->id); ?>" <?php if ($currentValue != ""){ echo("value=\"{$currentValue}\""); } ?> <?php if(isset($this->tabIndex)){echo("tabindex=$this->tabIndex");} ?> />
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
			$(function () {
				
				var timezone = moment.tz.guess();
				console.log(timezone);
				
                $("#<?php echo($this->id); ?>").datetimepicker({
					useCurrent: true,
					showTodayButton: true,
					showClear: true,
					timeZone: timezone,
					format: "YYYY-MM-DD hh:mm A Z"
				});
				$("#<?php echo($this->id); ?>").data("DateTimePicker").minDate("<?php echo($this->minDate); ?>");
				$("#<?php echo($this->id); ?>").data("DateTimePicker").maxDate("<?php echo($this->maxDate); ?>");
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