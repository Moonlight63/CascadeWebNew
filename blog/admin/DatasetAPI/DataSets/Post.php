<?php
require_once(__DIR__ . "/DataSet_Base.php");

class DataSet_Post extends DataSet_Base{
	
	public function constructSettings(){
		$this->setSetting("folder", "posts");
		$this->setSetting("canDelete", true);
		$this->setSetting("slugPattern", "D_N");
	}
	
	public function constructElements(){
		//$array = ["label" => function(){return "This is Text!!!...";},"id" => "test" ,"placeHolder" => "empty", "validation" => ["required"]];
		//$this->setElement(DataField_TextField::build($array));
		//$this->setElement(DataField_TextField::buildArray(["Test", "Test2", function(){return "This is Text!!!...";}, "test4"]));
		
		$testData = function(){
			try{
				if(isset($this->getCurrentData()["publishdate"])){
					$pubdate = $this->getCurrentData()["publishdate"];
					if($pubdate != ""){
						return self::normalizeDateTime(self::dateTimeFromString($pubdate)) <= self::normalizeDateTime(new DateTime());
					}else{
						return false;
					}
				}
			}
			catch (Exception $e){
				return DateTime::getLastErrors();
			}
			//$datetime = var_dump(DateTime::createFromFormat("Y-m-d h:i:sA (P)", $this->getCurrentData()["date_created"]));
			//return var_dump(DateTime::getLastErrors());
		};
		
		$this->setElement(DataField_TextField::buildArray(["name", "Title", "Post Title", "required"]));
		$this->setElement(DataField_TagInput::buildArray(["tags", "Tags", ["file" => "./categories.json"], "false", ""]));
		$this->setElement(DataField_ImgDragZone::buildArray(["headerImg", "Header Image", ""]));
		$this->setElement(DataField_Dropzone::buildArray(["fileDropzone", "Media Pool", addslashes($this->workingDir), "body"]));
		$this->setElement(DataField_froalaRTE::buildArray(["body", "Main Body", addslashes($this->workingDir), "fileDropzone", ""]));
		
		
		if( (!isset($this->getCurrentData()["publishdate"]) || self::normalizeDateTime(self::dateTimeFromString($this->getCurrentData()["publishdate"])) > self::normalizeDateTime(new DateTime())) || $_SESSION['UserData']['role'] == "admin" ){
			$this->setElement(DataField_DateFieldWithClear::buildArray(["publishdate", "Publish Date", $_SESSION['UserData']['role'] == "admin" ? "false" : self::dateTimeToString(self::normalizeDateTime(new DateTime())), "false", "Don't Publish", ""]));
		}
		
		if( isset($this->getCurrentData()["publishdate"]) && self::normalizeDateTime(self::dateTimeFromString($this->getCurrentData()["publishdate"])) <=  self::normalizeDateTime(new DateTime())){
			$this->setElement(DataField_HiddenInput::buildArray(["lastedited", self::dateTimeToString(self::normalizeDateTime(new DateTime())), ""]));
			$this->setSetting("canDelete", false);
		}
		
		
		$this->setElement(DataField_HiddenInput::buildArray(["author", $_SESSION['UserData']['UID'], ""]));
		//$this->setElement(DataField_ButtonToggle::buildArray(["publishReady", "Visible", "Yes", "No"]));
		
		
	}
	
}

?>