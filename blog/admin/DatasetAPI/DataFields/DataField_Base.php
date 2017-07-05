<?php

class DataField_Base{
	public $id;
	public $isVisible;
	protected $tabIndex;
	
	public static function buildArray($arr){
		return static::build(array_combine(static::$properties, $arr));
	}
	
	public static function build($args){
		if ( !isset($args["id"]) || empty($args["id"]) ) { $args["id"] = uniqid(); }
		$newargs = self::callArgs($args);
		$newobj = new static();
		$newobj->set($newargs);
		return $newobj;
	}
	
	protected static function callArgs($argsArray){
		$flag = [];
		foreach($argsArray as $key => $value){
			if(is_callable($value)){
				$flag[$key] = $value();
			}else{
				$flag[$key] = $value;
			}
		}
		return $flag;
	}
	
	public function setTabIndex($index){
		$this->tabIndex = $index;
		return $this;
	}
	
	protected function set($args){
		foreach($args as $key => $value){
			$this->{$key} = $value;
		}
		//$this->args = $args;
	}
	
	
	public function getHTML(){
		return "";
	}
	
	public function getJS(){
		return "";
	}
	
	public function getIncludes(){
		return "";
	}
	
	public function __get( $key ){
        return "No Value";
    }
	
	public static function getRelativePath($from, $to){
		// some compatibility fixes for Windows paths
		$from = is_dir($from) ? rtrim($from, '\/') . '/' : $from;
		$to   = is_dir($to)   ? rtrim($to, '\/') . '/'   : $to;
		$from = str_replace('\\', '/', $from);
		$to   = str_replace('\\', '/', $to);

		$from     = explode('/', $from);
		$to       = explode('/', $to);
		$relPath  = $to;

		foreach($from as $depth => $dir) {
			// find first non-matching dir
			if($dir === $to[$depth]) {
				// ignore this directory
				array_shift($relPath);
			} else {
				// get number of remaining dirs to $from
				$remaining = count($from) - $depth;
				if($remaining > 1) {
					// add traversals up to first matching dir
					$padLength = (count($relPath) + $remaining - 1) * -1;
					$relPath = array_pad($relPath, $padLength, '..');
					break;
				} else {
					$relPath[0] = './' . $relPath[0];
				}
			}
		}
		return implode('/', $relPath);
	}
	
	public static function getPathToIncludes(){
		
		$currDir = $_SERVER["SCRIPT_NAME"];
		$incsDir = substr(realpath(__DIR__. "/../Includes/"), strlen($_SERVER['DOCUMENT_ROOT'])) ;
		return self::getRelativePath($currDir, $incsDir);
		
	}

	public function postProccessValue($value, $oldValue = null){
		return ($value);
	}
}

?>