<?php
session_start();
require_once(__DIR__ . "/inc/functions.php");

/*Detect AJAX and POST request*/
if((empty($_SERVER['HTTP_X_REQUESTED_WITH']) or strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) != 'xmlhttprequest') or empty($_POST)){
  exit("Unauthorized Acces");
}

/*Function to set JSON output*/
function output($Return=array()){
    /*Set response header*/
    header("Access-Control-Allow-Origin: *");
    header("Content-Type: application/json; charset=UTF-8");
    /*Final JSON response*/
    exit(json_encode($Return));
}

/* Check Login form submitted */
if(!empty($_POST) && $_POST['Action']=='login_form'){
    /* Define return | here result is used to return user data and error for error message */
	require_once("DatasetAPI/datasets.php");
    $Return = array('result'=>array(), 'error'=>'');

    $user_name = htmlspecialchars(strtolower($_POST['Name']));
    $password = htmlspecialchars($_POST['Password']);

    if($user_name===''){
		$Return['error'] = "Please enter your username.";
	}elseif($password===''){
		$Return['error'] = "Please enter your Password.";
	}
	
	if($Return['error']!=''){
        output($Return);
    }else{
		$user = (new DataSet_User())->get($user_name);
		if($user === false){
			$Return['error'] = "That name doesn't exist.";
		}else{
			if(isset($user['accountActivated']) && $user['accountActivated'] == "false"){
				$Return['error'] = "That account has been deactivated.";
			}elseif($user['password'] != md5($password)){
				$Return['error'] = 'Invalid Login Credential.';
			}else{
				//Logged in
				$Return['result'] = $_SESSION['UserData'] = $user;
			}
		}
		output($Return);
	}
	
}

if(!empty($_POST) && $_POST['Action']=='add_category_form'){
    /* Define return | here result is used to return user data and error for error message */
    $Return = array('result'=>array(), 'error'=>'');

    $name = htmlspecialchars($_POST['Name']);

    /* Server side PHP input validation */
	if($name===''){
		$Return['error'] = "Please enter a Category Name.";
	}
    
	if($Return['error']!=''){
        output($Return);
    }
	
	if (file_exists(__DIR__ . "/categories.json")) {
		$writeData = json_decode(file_get_contents(__DIR__ . "/categories.json"), true);
	} else {
		$writeData = array();
	}
	if(in_array($name, $writeData)){
		$Return['error'] = "That category already exists.";
		output($Return);
	}
	
	$writeData[] = $name;
	
	file_put_contents(__DIR__ . "/categories.json", json_encode($writeData));
	
	$Return['result'] = $name;
	output($Return);

}


function delTree($dir){ 
	$files = array_diff(scandir($dir), array('.', '..')); 
	foreach ($files as $file) { 
		(is_dir("$dir/$file")) ? delTree("$dir/$file") : unlink("$dir/$file"); 
	}
	return rmdir($dir); 
}

/* Creates a new user */
if(!empty($_POST) && $_POST['Action']=='LogInAs'){
	$Return = array('result'=>array(), 'error'=>'');
	$user = get_author($_POST['userID']);
	$_SESSION['True_UserData'] = $_SESSION['UserData'];
	$_SESSION['UserData'] = $user;
	$Return["result"] = $user;
	output($Return);
}


if(!empty($_POST) && $_POST['Action']=='createEntry'){
	require_once("DatasetAPI/datasets.php");
	
	$DataSet = $_POST["entryType"];
	$DataSet = new $DataSet("NEW_SET");
	
	unset($_POST["Action"]);
	unset($_POST["entryType"]);
	
	$result = $DataSet->putData($_POST);
	if(!empty($result["error"])){
		$folder = $_SERVER['DOCUMENT_ROOT'].$DataSet->workingDir;
		delTree($folder);
	}
	
	output($result);
}

if(!empty($_POST) && $_POST['Action']=='editEntry'){
	require_once("DatasetAPI/datasets.php");
	$Return = array('result'=>array(), 'error'=>array());
	
	$entryID = $_POST["entryID"];
	$DataSet = $_POST["entryType"];
	$DataSet = new $DataSet($entryID);
	
	unset($_POST["Action"]);
	unset($_POST["entryID"]);
	unset($_POST["entryType"]);
	
	output($DataSet->putData($_POST));
}

if(!empty($_POST) && $_POST['Action']=='delete_entry'){
	$Return = array('result'=>array(), 'error'=>'');
	
	require_once("DatasetAPI/datasets.php");
	
	$DataSet = $_POST["entryType"];
	$DataSet = new $DataSet();
	
	$entryID = $_POST["entryID"];
	
	$entry_data = $DataSet->get($entryID);
	$folder = (__DIR__ . "/../dataSets/") . $DataSet->getSetting("folder") . "/{$entry_data["UID"]}";
	
	if($DataSet->getSetting("canDelete") || $entry_data["firstCreate"]){
		delTree($folder);
		$Return['result'] = $entry_data["UID"];
	}else{
		$Return['error'] = "This entry can not be deleted";
	}
	output($Return);
}


?>