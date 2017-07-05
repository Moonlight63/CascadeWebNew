<?php

if($DataFieldsHandle = opendir(__DIR__ . "/../DataFields/")) {
	while ($entry = readdir($DataFieldsHandle)) {
		if((substr($entry, -strlen(".php")) === ".php")){
			require_once(__DIR__ . "/../DataFields/{$entry}");
		}
	}
}

class DataSet_Base{
	
	private $elements;
	private $settings;
	private $currentData;
	
	public $baseDir;
	public $workingDir;
	
	//Construct new or existing dataset	
	public function __construct($ID = null){
		$this->constructSettings();
		if(!file_exists(__DIR__. "/../../../DataSets/".$this->getSetting("folder"))){
			mkdir(__DIR__. "/../../../DataSets/".$this->getSetting("folder"), 0777, true);
		}
		$this->baseDir = str_replace(['\\', '\\\\'], '/', substr(realpath(__DIR__. "/../../../DataSets/".$this->getSetting("folder")), strlen($_SERVER['DOCUMENT_ROOT']))) ;
		if(isset($ID)){
			if($ID == "NEW_SET"){
				$this->setCurrentData($this->get($this->createNew()));				
			}else{
				$this->setCurrentData($this->get($ID));
			}			
			$this->workingDir = str_replace(['\\', '\\\\'], '/', substr(realpath(__DIR__. "/../../../DataSets/".$this->getSetting("folder")."/{$this->getCurrentData()["UID"]}"), strlen($_SERVER['DOCUMENT_ROOT']))) ;
			$this->constructElements();
		}
	}
	
	public function cleanEntries(){
		$all = $this->getAll();
		if(!empty($all) && $all !== false){
			foreach($all as $entry){
				if($entry["firstCreate"]){
					$this->removeEntry($entry["UID"]);
				}
			}
		}
		return $this;
	}
	
	public function removeEntry($entryUID){
		$dir = $_SERVER['DOCUMENT_ROOT'].$this->baseDir."/".$entryUID;
		$files = array_diff(scandir($dir), array('.', '..')); 
		foreach ($files as $file) { 
			(is_dir("$dir/$file")) ? $this->removeEntry("$dir/$file") : unlink("$dir/$file"); 
		}
		return rmdir($dir); 
	}
	
	private function setCurrentData($values){
		$this->currentData = $values;
	}
	
	protected function setDefaultData($key, $value){
		if(isset($key) && isset($value)){
			$this->currentData[$key] = $value;
			return $this;
		}else{
			return false;
		}		
	} 
	
	public function getCurrentData(){
		if (isset($this->currentData)) {
			return $this->currentData;
		} else {
			return false;
		}
	}
	
	
	public static function normalizeDateTime($DatetimeObject){
		return $DatetimeObject->setTimezone(new DateTimeZone("UTC"));
	}
	//Y-m-d h:iA T
	//Y-m-d H:i:P
	public static function dateTimeToString($DateTimeObject){
		return $DateTimeObject->format("Y-m-d h:i:s A P");
	}
	public static function dateTimeFromString($DateTimeString){
		if(DateTime::createFromFormat("Y-m-d h:i:s A P", $DateTimeString) !== false){
			return DateTime::createFromFormat("Y-m-d h:i:s A P", $DateTimeString);
		} elseif(DateTime::createFromFormat("Y-m-d h:i A P", $DateTimeString)){
			return DateTime::createFromFormat("Y-m-d h:i A P", $DateTimeString);
		} else { return false; }
	}
	
	
	private function createNew(){
		
		$folder = $_SERVER['DOCUMENT_ROOT'].$this->baseDir;
		
		$slugPattern = $this->getSetting("slugPattern") != false ? $this->getSetting("slugPattern") : "D_N";

		$entry_data = array();

		$UID = uniqid();

		$entry_data['UID'] 			= $UID;
		$entry_data['name'] 		= "Entry-" . $UID;
		$entry_data['datetime_created'] = self::dateTimeToString(self::normalizeDateTime(new DateTime()));
		$entry_data['date_created'] = self::normalizeDateTime(new DateTime())->format("Y-m-d");
		$entry_data['firstCreate'] 	= true;

		$slug = str_replace("D", $entry_data['date_created'], str_replace("U", $UID, str_replace("N", strtolower(str_replace(" ", "-", $entry_data['name'])), $slugPattern)));
		$entry_data['slug'] 		= $slug;
		
		mkdir($folder . "/{$UID}", 0777, true);
		
		if(!(!file_put_contents($folder . "/{$UID}/" . "entrydata.json", json_encode($entry_data)))){
			return $UID;
		}else{
			return "Failed to put data!";
		}
		
	}
	
	
	protected function setSetting($setting, $value){
		$this->settings[$setting] = $value;
	}
	
	protected function setElement($element){
		$this->elements[$element->id] = $element;
	}
	
	public function getSettings(){
		if(isset($this->settings)){
			return $this->settings;
		}
		return(false);
	}
	public function getElements(){
		if(isset($this->elements)){
			return $this->elements;
		}
		return(false);
	}
	public function getSetting($setting){
		if($this->getSettings() != false && isset($this->getSettings()[$setting])){
			return $this->getSettings()[$setting];
		}
		return(false);
	}
	public function getElement($element){
		if($this->getElements() != false && isset($this->getElements()[$element])){
			return $this->getElements()[$element];
		}
		return(false);
	}
	
	
	public function getCurrentDataForElement($elem){
		$data = "";
		if(isset($this->currentData[$elem->id]) && !$this->currentData["firstCreate"]){
			$data = $this->currentData[$elem->id];
		}
		return $data;
	}
	public function getIncludes(){
		
		$tmpInc = [];
		foreach($this->getElements() as $element){
			$tmpInc[] = $element->getIncludes();
		}
		$tmpInc = implode("", array_unique($tmpInc));
		
		return $tmpInc;
		
	}
	public function getHTML(){
		
		$tmpHTML = [];
		foreach($this->getElements() as $element){
			$tmpHTML[] = $element->getHTML($this->getCurrentDataForElement($element));
		}
		$tmpHTML = implode("", array_unique($tmpHTML));
		
		return $tmpHTML;
		
	}
	public function getJS(){
		
		$tmpJS = [];
		foreach($this->getElements() as $element){
			$tmpJS[] = $element->getJS($this->getCurrentDataForElement($element));
		}
		$tmpJS = implode("", array_unique($tmpJS));
		
		return $tmpJS;
		
	}
	
	
	public function putData($values){
		$Return = array('result'=>array(), 'error'=>array());
		$folder = $_SERVER['DOCUMENT_ROOT'].$this->workingDir;
		$slugPattern = $this->getSetting("slugPattern") != false ? $this->getSetting("slugPattern") : "D_N";
		$entry_data = $this->getCurrentData();
		
		foreach($values as $inputName => $inputValue){
			$elem = $this->getElement($inputName);
			if($elem != false){	
				$result = $elem->validate($inputValue, $values, $this->getCurrentDataForElement($elem));
				
				if(!empty(array_filter($result))){
					$Return["error"][] = $result;
				}
				if(!empty($Return["error"])){
					continue;
				}
				$entry_data[$inputName] = $elem->postProccessValue($inputValue, $this->getCurrentDataForElement($elem));
			}
		}

		$newSlug = str_replace("D", $entry_data["date_created"], str_replace("U", $entry_data['UID'], str_replace("N", strtolower(str_replace(" ", "-", $entry_data['name'])), $slugPattern)));

		//$newSlug = $entry_data["date_created"] . "_" . strtolower(str_replace(" ", "-", $entry_data['name']));

		if($newSlug != $entry_data["slug"]){
			if($this->get($newSlug) != false){
				$Return["error"][] = "That entry already exists. Please use a different name.";
			}else{
				$entry_data["slug"] = $newSlug;
			}
		}

		if(!empty($Return["error"])){
			return($Return);
		}else{
			$entry_data["firstCreate"] = false;
			
			file_put_contents($folder . "/entrydata.json", json_encode($entry_data));
			$Return["result"] = $entry_data;
		}

		return($Return);
	}
	
	
	public function getAll($sort = null){
		return ($this->get_all_entrys($sort));
	}
	public function get($arg){
		return ($this->get_entry($arg));
	}
	
	
	/*-----------------------------------------------------------------------------------*/
	/* Get Entry
	/*-----------------------------------------------------------------------------------*/

	protected function get_entry_UID($entrySlug){
		$dir = $_SERVER['DOCUMENT_ROOT'].$this->baseDir;
		if($handle = opendir($dir)) {
			while ($entry = readdir($handle)) {
				if(is_dir($dir."/{$entry}/")) {
					if(file_exists($dir."/{$entry}/entrydata.json")){
						$filecontents = file_get_contents($dir."/{$entry}/entrydata.json");
						$data = json_decode($filecontents, TRUE);
						if($data["slug"] == $entrySlug){
							return($data["UID"]);
						}
					}
				}
			}
		}
		return false;
	}

	protected function get_entry($entry_uid){
		$dir = $_SERVER['DOCUMENT_ROOT'].$this->baseDir;
		//return $this->baseDir."/{$entry_uid}/";
		if(file_exists($dir . "/{$entry_uid}/")){
			$dir .= "/{$entry_uid}/";
		}else{
			$entry_uid = $this->get_entry_UID($entry_uid);
			if($entry_uid != false){
				$dir .= "/{$entry_uid}/";
			}else{return false;}
		}

		if(file_exists($dir."entrydata.json")){
			$filecontents = file_get_contents($dir."entrydata.json");
			$data = json_decode($filecontents, TRUE);
			if($data["UID"] == $entry_uid){
				return($data);
			}
		}
	}


	protected function get_all_entrys($sortParam = null) {
		$dir = $_SERVER['DOCUMENT_ROOT'].$this->baseDir;
		
		if(!isset($sortParam)){
			$sortParam = "datetime_created";
		}
		
		
		if($handle = opendir($dir)) {
			$files = array();
			while ($entry = readdir($handle)) {
				if(is_dir($dir."/{$entry}/")) {
					if ($entry != "." && $entry != "..") {
						$data = $this->get_entry($entry);
						if($data != false){
							$flag = true;
							$files[] = $data;
							
							if(!isset($data[$sortParam])){
								$sortParam = "datetime_created";
							}
							if(self::dateTimeFromString($data[$sortParam]) != false){
								$sort[] = self::dateTimeFromString($data[$sortParam]);
							}else{
								$sort[] = $data[$sortParam];
							}
							
						}
					}
				}
			}

			if(isset($flag)){
				array_multisort($sort, SORT_DESC, $files);
				return $files;
			}else{return(false);}

		} else {
			return false;
		}
	}	
	
}

?>