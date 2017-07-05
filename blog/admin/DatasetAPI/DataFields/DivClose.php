<?php
require_once(__DIR__ . "/DataField_Base.php");

class DataField_DivClose extends DataField_Base{
	
	public static $properties = [];
	
	public function getHTML(){
		ob_start();
		?>
		 
		</div <?php echo($this->id); ?>>
		
		<?php 
		$content = ob_get_contents();
		ob_end_clean();

		return($content);
	}
	
}

?>