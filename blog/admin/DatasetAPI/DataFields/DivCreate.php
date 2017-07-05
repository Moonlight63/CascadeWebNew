<?php
require_once(__DIR__ . "/DataField_Base.php");

class DataField_DivCreate extends DataField_Base{
	
	public static $properties = [
		"id", "class"
	];
	
	public function getHTML(){
		ob_start();
		?>
		<div id="<?php echo($this->id); ?>" class="<?php echo($this->class); ?>">
		<?php 
		$content = ob_get_contents();
		ob_end_clean();

		return($content);
	}
	
}

?>