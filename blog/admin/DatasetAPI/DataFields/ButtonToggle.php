<?php
require_once(__DIR__ . "/DataField_Base.php");

class DataField_ButtonToggle extends DataField_Base{
	
	public static $properties = [
		"id", "label", "onTxt", "offTxt"
	];
	
	public function getHTML($currentValue = ""){
		ob_start();
		?>
		
		<div class="btn-group btn-toggle" data-toggle="buttons">
			<label class="btn btn-lg <?php echo($currentValue == "true" ? "btn-default" : "btn-info active");?>">
				<input type="radio" name="<?php echo($this->id); ?>" value="false" <?php echo($currentValue == "true" ? "" : "checked");?>> <?php echo($this->offTxt); ?>
			</label>
			<label class="btn btn-lg <?php echo($currentValue == "true" ? "btn-info active" : "btn-default");?>">
				<input type="radio" name="<?php echo($this->id); ?>" value="true" <?php echo($currentValue == "true" ? "checked" : "");?>> <?php echo($this->onTxt); ?>
			</label>
		</div>

		<?php 
		$content = ob_get_contents();
		ob_end_clean();

		return($content);
	}
	
	public function getJS($currentValue = ""){
		ob_start();
		?>
		
		<script>
		$(".btn-toggle :input").change(function(){
			$(this).closest(".btn-toggle").find(".btn").removeClass("btn-info").addClass("btn-default");
			if($(this).prop("checked")){
				$(this).parent().addClass("btn-info").removeClass("btn-default");
			}
		});
		</script>

		<?php 
		$content = ob_get_contents();
		ob_end_clean();

		return($content);
	}
	
	public function validate(){
		return([]);
	}
	
}

?>