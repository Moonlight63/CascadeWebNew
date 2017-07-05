<?php
session_start();

require_once("DatasetAPI/datasets.php");

if((new DataSet_User())->cleanEntries()->getAll() === false || (new DataSet_Settings())->cleanEntries()->getAll() === false){
	exit(header("location:setup.php"));
}

if (isset($_SESSION['UserData'])) {
    exit(header("location:./"));
}

?>
<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <title>Dashboard Login</title>
</head>
<body>
	
	<!-- Login Form -->
	<div class="container">
		<!-- HTML Form -->
		<form action="submit.php" method="post" name="login_form" id="login_form" autocomplete="off" novalidate>
			<h2 class="form-signin-heading">Login</h2>

			<div class="form-group">
				<label for="Name" class="sr-only">User Name</label>
				<input type="text" name="Name" id="Name" class="form-control" placeholder="Username" required pattern=".{2,100}" autofocus>
			</div>
			<div class="form-group has-feedback">
				<label for="Password" class="sr-only">Password</label>
				<input type="password" name="Password" id="Password" class="form-control" placeholder="Password" required>
			</div>

			<div id="display_error" class="alert alert-danger fade in"></div>

			<button type="submit" class="btn btn-lg btn-primary btn-block">Login</button>
		</form>
		<!-- /HTML Form -->
	</div>
	<!-- /container -->
	
	<!-- Include CSS -->
	<link href="css/bootstrap.css" rel="stylesheet"><!-- Bootstrap CSS -->
	<link href="./css/style.css" rel="stylesheet"><!--	 Custom CSS -->
	<!-- Include Google font -->
	<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto:400,300,600">
	<!-- Include JavaScripts -->
	<script src="./js/jquery-1.11.3.min.js"></script><!-- Load jquery -->
	<script src="js/bootstrap.js"></script><!-- Load bootstrap js -->
	
	<script>
		/*Login or Registration Form Submit*/
		$("#login_form").submit(function (e) {
			e.preventDefault();
			var obj = $(this);
			$("#login_form #display_error").hide().html("");
			$.ajax({
				type: "POST",
				url: e.target.action,
				data: obj.serialize()+"&Action=login_form",
				cache: false,
				success: function (JSON) {
					if (JSON.error != '') {
						$("#login_form #display_error").show().html(JSON.error);
					} else {
						window.location.href = "./";
					}
				}
			});
		});
	</script>
</body>
</html>