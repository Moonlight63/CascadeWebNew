<?php 

require_once(__DIR__ . "/DataSet_Base.php");

class DataSet_Tags{
	
	public function __construct(){
		parent::__construct();
		
		$this->setSetting("folder", "tags");
		$this->setSetting("canDelete", true);
		$this->setSetting("slugPattern", "N");
		
		$this->setElement(DataField_TagInput::buildArray(["tags", "Tags", [], ""]));
	}
	
}

?>