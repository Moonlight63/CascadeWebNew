<?php
require_once(__DIR__ . "/DataSet_Base.php");

class DataSet_User extends DataSet_Base{
	
	public function constructSettings(){
		$this->setSetting("folder", "users");
		$this->setSetting("canDelete", false);
		$this->setSetting("slugPattern", "N");
	}
	
	public function constructElements(){
		
		$this->setElement(DataField_DivCreate::buildArray(["", "row"]));
		
		$this->setElement(DataField_DivCreate::buildArray(["", "col-md-8"]));
		$this->setElement(DataField_TextField::buildArray(["name", "User Name", "Enter a login name", ["required", "nospace"]]));
		$this->setElement(DataField_TextField::buildArray(["displayName", "Display Name", "Enter a display name", "required"]));
		$this->setElement(DataField_PasswordCreate::buildArray(["password", "Password", "Password Confirm", "Enter a password", "Confirm your password", "required"]));
		$this->setElement(DataField_DivClose::buildArray([]));
		
		$this->setElement(DataField_DivCreate::buildArray(["", "col-md-4"]));
		$this->setElement(DataField_AvatarDropzone::buildArray(["avatar", "Avatar", addslashes($this->workingDir), "avatar", ""]));
		$this->setElement(DataField_DivClose::buildArray([]));
		
		$this->setElement(DataField_DivClose::buildArray([]));
		
		$this->setElement(DataField_TextArea::buildArray(["about", "About Author", ""]));
		
		if(isset($_SESSION["UserData"]) && $_SESSION["UserData"]["UID"] != $this->getCurrentData()["UID"]){
			$this->setElement(DataField_DropSelect::buildArray(["role", "Role", ["admin" => "Admin", "moderator" => "Moderator", "author" => "Author"]]));
		}
		
		if(!isset($_SESSION["UserData"])){
			$this->setDefaultData("role", "admin");
		}
		
		if(isset($_SESSION["UserData"]) && $_SESSION["UserData"]["UID"] != $this->getCurrentData()["UID"] && $_SESSION["UserData"]["role"] == "admin"){
			$this->setSetting("canDelete", true);
		}
		
	}
	
}

?>