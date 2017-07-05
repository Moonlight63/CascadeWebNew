<?php
require_once(__DIR__ . "/DataSet_Base.php");

class DataSet_Settings extends DataSet_Base{
	
	public function constructSettings(){
		$this->setSetting("folder", "settings");
		$this->setSetting("canDelete", false);
		$this->setSetting("slugPattern", "N");
	}
	
	public function constructElements(){
		
		$this->setDefaultData("name", "settings");
		
		$this->setElement(DataField_DivCreate::buildArray(["", "row"]));
		
		$this->setElement(DataField_DivCreate::buildArray(["", "col-md-6"]));
		$this->setElement(DataField_TextField::buildArray(["blogname", "Blog Title", "Name your blog", "required"])->setTabIndex(1));
		$this->setElement(DataField_TextField::buildArray(["sitename", "Website Name", "What is the name of your website?", "required"])->setTabIndex(3));
		$this->setElement(DataField_TextField::buildArray(["facebook", "Facebook User", "Your Facebook User Name", "required"])->setTabIndex(5));
		$this->setElement(DataField_TextField::buildArray(["twitter", "Twitter Handle", "Your Twitter Name", "required"])->setTabIndex(7));
		$this->setElement(DataField_DivClose::buildArray([]));
		
		$this->setElement(DataField_DivCreate::buildArray(["", "col-md-6"]));
		$this->setElement(DataField_TextField::buildArray(["blogurl", "Blog URL", "http://www.yourblogname.com/blog/", "required"])->setTabIndex(2));
		$this->setElement(DataField_TextField::buildArray(["siteurl", "Website URL", "http://www.yourwebsite.com/", "required"])->setTabIndex(4));
		$this->setElement(DataField_TextField::buildArray(["facebookurl", "Facebook URL", "https://www.facebook.com/Your-User-Name/", "required"])->setTabIndex(6));
		$this->setElement(DataField_TextField::buildArray(["twitterurl", "Twitter URL", "https://twitter.com/Your-Twitter-Handle/", "required"])->setTabIndex(8));
		$this->setElement(DataField_DivClose::buildArray([]));
		
		$this->setElement(DataField_DivClose::buildArray([]));
		
		
		$this->setElement(DataField_DivCreate::buildArray(["", "row"]));
		$this->setElement(DataField_DivCreate::buildArray(["", "col-md-6"]));
		$this->setElement(DataField_TextArea::buildArray(["blogdesc", "Blog Description", ""])->setTabIndex(9));
		$this->setElement(DataField_DivClose::buildArray([]));
		$this->setElement(DataField_DivCreate::buildArray(["", "col-md-6"]));
		$this->setElement(DataField_AvatarDropzone::buildArray(["blogimg", "Blog Image", addslashes($this->workingDir), "blogimg", ""]));
		$this->setElement(DataField_DivClose::buildArray([]));
		$this->setElement(DataField_DivClose::buildArray([]));
		
//		$this->setElement(DataField_DivCreate::buildArray(["", "row"]));
//		
//		$this->setElement(DataField_DivCreate::buildArray(["", "col-md-8"]));
//		
//		$this->setElement(DataField_TextField::buildArray(["displayName", "Display Name", "Enter a display name", "required"]));
//		$this->setElement(DataField_PasswordCreate::buildArray(["password", "Password", "Password Confirm", "Enter a password", "Confirm your password", "required"]));
//		$this->setElement(DataField_DivClose::buildArray([]));
//		
//		$this->setElement(DataField_DivCreate::buildArray(["", "col-md-4"]));
//		$this->setElement(DataField_AvatarDropzone::buildArray(["avatar", "Avatar", addslashes($this->workingDir), "avatar", ""]));
//		$this->setElement(DataField_DivClose::buildArray([]));
//		
//		$this->setElement(DataField_DivClose::buildArray([]));
//		
//		$this->setElement(DataField_TextArea::buildArray(["about", "About Author", ""]));
//		
//		if(isset($_SESSION["UserData"]) && $_SESSION["UserData"]["UID"] != $this->getCurrentData()["UID"]){
//			$this->setElement(DataField_DropSelect::buildArray(["role", "Role", ["admin" => "Admin", "moderator" => "Moderator", "author" => "Author"]]));
//		}
		
	}
	
}

?>