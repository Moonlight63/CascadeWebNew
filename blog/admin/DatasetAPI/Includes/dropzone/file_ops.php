<?php

//require_once(__DIR__ . "/functions.php");

function isFileValid($filename, $mimeType, $allowedExts, $allowedMimeTypes) {
	// Skip if the allowed extensions or mime types are missing.
	if (!$allowedExts || !$allowedMimeTypes) {
		return false;
	}
	// Get extension.
	$extension = end($filename);
	return in_array(strtolower($mimeType), $allowedMimeTypes) && in_array(strtolower($extension), $allowedExts);
}

function getMimeType($tmpName) {
	$mimeType = mime_content_type($tmpName);
	return $mimeType;
}

function isValid($validation, $fieldname) {
	// No validation means you dont want to validate, so return affirmative.
	if (!$validation) {
		return true;
	}
	// Get filename.
	$filename = explode(".", $_FILES[$fieldname]["name"]);
	// Validate uploaded files.
	// Do not use $_FILES["file"]["type"] as it can be easily forged.
	$mimeType = getMimeType($_FILES[$fieldname]["tmp_name"]);
	// Validation is a function provided by the user.
	if ($validation instanceof \Closure) {
		return $validation($_FILES[$fieldname]["tmp_name"], $mimeType);
	}
	if (is_array($validation)) {
		return isFileValid($filename, $mimeType, $validation['allowedExts'], $validation['allowedMimeTypes']);
	}
	// Else: no specific validating behaviour found.
	return false;
}


function upload($fileRoute, $options, $name) {
	$fieldname = $options['fieldname'];
	if (empty($fieldname) || empty($_FILES[$fieldname])) {
		throw new \Exception('Fieldname is not correct. It must be: ' . $fieldname);
	}
	if (isset($options['validation']) && !isValid($options['validation'], $fieldname)) {
		throw new \Exception('File does not meet the validation.');
	}
	// Get filename.
	$temp = explode(".", $_FILES[$fieldname]["name"]);
	// Get extension.
	$extension = end($temp);
	// Generate new random name.
	if($name == NULL){
		$name = sha1(microtime()) . "." . $extension;
	}else{
		$name = $name . "." . $extension;
	}
	$fullNamePath = $_SERVER['DOCUMENT_ROOT'] . $fileRoute . $name;
	$mimeType = getMimeType($_FILES[$fieldname]["tmp_name"]);
	if (isset($options['resize']) && $mimeType != 'image/svg+xml') {
		// Resize image.
		$resize = $options['resize'];
		// Parse the resize params.
		$columns = $resize['columns'];
		$rows = $resize['rows'];
		$filter = isset($resize['filter']) ? $resize['filter'] : \Imagick::FILTER_UNDEFINED;
		$blur = isset($resize['blur']) ? $resize['blur'] : 1;
		$bestfit = isset($resize['bestfit']) ? $resize['bestfit'] : false;
		$imagick = new \Imagick($_FILES[$fieldname]["tmp_name"]);
		$imagick->resizeImage($columns, $rows, $filter, $blur, $bestfit);
		$imagick->writeImage($fullNamePath);
		$imagick->destroy();
	} else {
		// Save file in the uploads folder.
		move_uploaded_file($_FILES[$fieldname]["tmp_name"], $fullNamePath);
	}
	// Generate response.
	$response = new \StdClass;
	$response->link = $fileRoute . $name;
	$response->thumb = $fileRoute . $name;
	$response->name = $name;
	$response->fileSize = filesize($fullNamePath);
	$response->mime = $mimeType;
	return $response;
}

function delete($src) {
	$filePath = $_SERVER['DOCUMENT_ROOT'] . $src;
	// Check if file exists.
	if (file_exists($filePath)) {
		// Delete file.
		return unlink($filePath);
	}
	return true;
}


$defaultImageUploadOptions = array(
	'fieldname' => 'file',
	'validation' => array(
		'allowedExts' => array('gif', 'jpeg', 'jpg', 'png', 'svg', 'blob'),
		'allowedMimeTypes' => array('image/gif', 'image/jpeg', 'image/pjpeg', 'image/x-png', 'image/png', 'image/svg+xml')
	),
	'resize' => NULL
);

$uploadImage = function($fileRoute, $name = NULL, $options = NULL) use ($defaultImageUploadOptions) {
	// Check if there are any options passed.
	if (is_null($options)) {
		$options = $defaultImageUploadOptions;
	} else {
		$options = array_merge($defaultImageUploadOptions, $options);
	}
	// Upload image.
	return upload($fileRoute, $options, $name);
};

$getList = function($folderPath, $thumbPath = null) use ($defaultImageUploadOptions) {
	if (empty($thumbPath)) {
		$thumbPath = $folderPath;
	}
	// Array of image objects to return.
	$response = array();
	$absoluteFolderPath = $_SERVER['DOCUMENT_ROOT'] . $folderPath;
	// Image types.
	$image_types = $defaultImageUploadOptions['validation']['allowedMimeTypes'];
	// Filenames in the uploads folder.
	$fnames = scandir($absoluteFolderPath);
	// Check if folder exists.
	if ($fnames) {
		// Go through all the filenames in the folder.
		foreach ($fnames as $name) {
			// Filename must not be a folder.
			if (!is_dir($name)) {
				// Check if file is an image.
				if (in_array(mime_content_type($absoluteFolderPath . $name), $image_types)) {
					// Build the image.
					$img = new \StdClass;
					$img->url = $folderPath . $name;
					$img->thumb = $thumbPath . $name;
					$img->name = $name;
					$img->fileSize = filesize($absoluteFolderPath . $name);
					$img->mime = mime_content_type($absoluteFolderPath . $name);
					// Add to the array of image.
					array_push($response, $img);
				}
			}
		}
	}
	// Folder does not exist, respond with a JSON to throw error.
	else {
		throw new Exception('Images folder does not exist!');
	}
	return $response;
};


$defaultFileUploadOptions = array(
	'fieldname' => 'file',
	'validation' => array(
		'allowedExts' => array('txt', 'pdf', 'doc'),
		'allowedMimeTypes' => array('text/plain', 'application/msword', 'application/x-pdf', 'application/pdf')
	)
);

$uploadFile = function($fileRoute, $name = NULL, $options = NULL) use ($defaultFileUploadOptions) {
	if (is_null($options)) {
		$options = $defaultFileUploadOptions;
	} else {
		$options = array_merge($defaultFileUploadOptions, $options);
	}
	return upload($fileRoute, $options, $name);
};


if(isset($_POST['reqType']) && $_POST['reqType'] == 'imgUpload'){
	try {
		$dir = $_POST['folder'] . "/";
		$response = $uploadImage($dir);
		echo (json_encode($response));
	}
	catch (Exception $e) {
		echo ($e);
		//http_response_code(404);
	}
}

if(isset($_POST['reqType']) && $_POST['reqType'] == 'imgUploadWithName'){
	try {
		$dir = $_POST['folder'] . "/";
		$response = $uploadImage($dir, $_POST['name']);
		echo (json_encode($response));
	}
	catch (Exception $e) {
		echo ($e);
		//http_response_code(404);
	}
}

if(isset($_GET['reqType']) && $_GET['reqType'] == 'imgList'){
	try {
		$dir = $_GET['folder'] . "/";
		//echo($dir);
	  	$response = $getList($dir);
	  	echo (json_encode($response));
	}
	catch (Exception $e) {
		echo ($e);
	  	//http_response_code(404);
	}
}

if(isset($_POST['reqType']) && $_POST['reqType'] == 'imgDelete'){
	try {
	  	$response = delete($_POST['src']);
	  	echo stripslashes(json_encode('Success'));
	}
	catch (Exception $e) {
	  	http_response_code(404);
	}
}

?>
