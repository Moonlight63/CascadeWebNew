<?php 

/*-----------------------------------------------------------------------------------*/
/* Debug Mode
/*-----------------------------------------------------------------------------------*/

$display_errors = true;

// Display errors if there are any.
ini_set('display_errors', $display_errors);


/*-----------------------------------------------------------------------------------*/
/* Definitions
/*-----------------------------------------------------------------------------------*/

$language = 'en-us';
$feed_max_items = 4;
$date_format = 'F jS, Y';

// Get the components of the current url.
$protocol = @( $_SERVER["HTTPS"] != 'on') ? 'http://' : 'https://';
$domain = $_SERVER["SERVER_NAME"];
$port = $_SERVER["SERVER_PORT"];
$path = $_SERVER["REQUEST_URI"];

// Check if running on alternate port.
if ($protocol === "https://") {
	if ($port == 443)
		$url = $protocol . $domain;
	else
		$url = $protocol . $domain . ":" . $port;
} elseif ($protocol === "http://") {
	if ($port == 80)
		$url = $protocol . $domain;
	else
		$url = $protocol . $domain . ":" . $port;
}

$blogFolder = str_replace(['\\', '\\\\'], '/', substr(realpath(__DIR__. "/../../"), strlen($_SERVER['DOCUMENT_ROOT'])))."/";

define("BLOG_FOLDER", $blogFolder);

//$blogFolder = explode("/", $path)[1];
//$blogFolder = "/".$blogFolder;

/*-----------------------------------------------------------------------------------*/
/* Template Files
/*-----------------------------------------------------------------------------------*/
	
$template = "cap";

// Get the active template directory.
$template_dir = 'templates/' . $template;
//$template_dir_url = BLOG_URL . '/templates/' . $template;

// Get the active template files.
$index_file = $template_dir . '/index.php';
$post_file = $template_dir . '/post.php';
$posts_file = $template_dir . '/posts.php';
$author_file = $template_dir . '/author.php';
$not_found_file = $template_dir . '/404.php';
