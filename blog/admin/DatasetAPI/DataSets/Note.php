<?php
require_once(__DIR__ . "/DataSet_Base.php");

class DataSet_Note extends DataSet_Base{
	
	public function constructSettings(){
		$this->setSetting("folder", "notes");
		$this->setSetting("canDelete", true);
		$this->setSetting("slugPattern", "D_U_N");
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
		
		$this->setElement(DataField_PasswordCreate::buildArray(["password", "Password", "Password Confirm", "Enter a password", "Confirm your password", "required"]));
		
		$this->setElement(DataField_HiddenInput::buildArray(["lastedited", self::dateTimeToString(self::normalizeDateTime(new DateTime())), ""]));
		
		$this->setElement(DataField_DropSelect::buildArray(["role", "Role", ["admin" => "Admin", "moderator" => "Moderator", "author" => "Author"]]));
		
		$this->setElement(DataField_DateFieldWithClear::buildArray(["publishdate", json_encode($testData()), self::dateTimeToString(self::normalizeDateTime(new DateTime())), "false", "Don't Publish", ""]));
		//$this->setElement(DataField_DateField::buildArray(["publishdate", "Publish Date", ""]));
		
		$this->setElement(DataField_TextField::buildArray(["name", "Name", "Note Name", "required"]));
		$this->setElement(DataField_TagAddInput::buildArray(["tags", "Tags", ["phpCall" => function(){
			if(file_exists("./categories.json")){
				return json_decode(file_get_contents("./categories.json"), true);
			}else{
				return [];
			}
		}], "false", "+ Add New", "Add a new tag!", "submit.php",
		function(){
			ob_start();
			?>
			
			<script>
				
				$("#tagsModalForm").submit(function (e) {
					e.preventDefault();
					var obj = $(this);
					$("#tagsModalForm #display_error").hide().html("");
					$.ajax({
						type: "POST",
						url: e.target.action,
						data: obj.serialize()+"&Action=outputToFile&file=categories.json",
						cache: false,
						success: function (JSON) {
							console.log(JSON);
							if (JSON.error != '') {
								$("#tagsModalForm #display_error").show().html(JSON.error);
							} 
							if (JSON.result != '') {
								tagsOptions.push(JSON.result);
								tagsBH.add([JSON.result]);
								$('#tagsModal').modal('hide');
							}
						}
					});
				});

			</script>
			
			<?php
			$content = ob_get_contents();
			ob_end_clean();
			return($content);
			
		}
		,""]));
		
		
		if($_SESSION["UserData"]["role"] == "admin"){
			$this->setElement(DataField_TagInput::buildArray(["tags2", "Tags 2", ["file" => "./categories.json"], "false", ""]));
		}
		$this->setElement(DataField_AvatarDropzone::buildArray(["avatarDrop", "Avatar", addslashes($this->workingDir), "avatar", ""]));
		$this->setElement(DataField_ImgDragZone::buildArray(["headerImg", "Header Image", ""]));
		$this->setElement(DataField_Dropzone::buildArray(["fileDropzone", "Media Pool", addslashes($this->workingDir), "body"]));
		$this->setElement(DataField_froalaRTE::buildArray(["body", "Main Body", addslashes($this->workingDir), "fileDropzone", ""]));
		
		$this->setElement(DataField_ButtonToggle::buildArray(["visible", "Visible", "Yes", "No"]));
		
	}
	
}

?>