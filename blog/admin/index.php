<?php
session_start();
require(__DIR__ . '/inc/settings.php');
require(__DIR__ . '/inc/functions.php');

/*Check for authentication otherwise user will be redirects to main.php page.*/
if (!isset($_SESSION['UserData'])) {
    exit(header("location:login.php"));
}else{
	exit(header("location:dashboard.php"));
}

?>
<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <title>PHP Login Script (PHP, MySQL, Bootstrap, jQuery, Ajax and JSON)</title>
</head>
<body>
	<!-- container -->
	<div class="container">
		Congratulation! You have logged into password protected page. <a href="logout.php">Click here</a> to Logout.
		<?php
			echo '<pre>';
			print_r($_SESSION);
			echo '</pre>';
		?>
	</div>
	<!-- /container -->
	<!-- Include CSS -->
	<link href="css/bootstrap.min.css" rel="stylesheet"><!-- Bootstrap CSS -->
	<link href="./css/style.css" rel="stylesheet"><!-- Custom CSS -->
	<!-- Include Google font -->
	<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto:400,300,600">
	<!-- Include JavaScripts -->
	<script src="./js/jquery.min.js" async></script><!-- Load jquery -->
	<script src="js/bootstrap.min.js" async></script><!-- Load bootstrap js -->
	<script src="./js/app.js" async></script><!-- Load custom js -->

</body>
</html>