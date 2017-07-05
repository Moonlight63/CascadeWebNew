<?php
session_start();

if (isset($_SESSION['UserData'])) {
    exit(header("location:./"));
}

require_once("DatasetAPI/datasets.php");

if((new DataSet_User())->cleanEntries()->getAll() == false){
	$DataSet = "DataSet_User";
}elseif((new DataSet_Settings())->cleanEntries()->getAll() == false){
	$DataSet = "DataSet_Settings";
}else{
	//exit(header("location:login.php"));
	$showLogin = true;
}

if(!isset($showLogin)){
	$dataset = (new $DataSet("NEW_SET"));
	$htmlData = $dataset->getHTML();
	$jsData = $dataset->getJS();
	$includes = $dataset->getIncludes();
	$entryData = $dataset->getCurrentData();	
}


/*Check for authentication otherwise user will be redirects to main.php page.*/
//if (!isset($_SESSION['UserData'])) {
//    exit(header("location:login.php"));
//}
?>

<!doctype html>
<html>
<head>
	<meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <?php if(!isset($showLogin)): if($DataSet == "DataSet_User"): ?>
	<title>First Time Setup | Create First User</title>
	<?php else: ?>
	<title>First Time Setup | Configure Settings</title>
	<?php endif; else:?>
	<title>First Time Setup | Done</title>
	<?php endif; ?>
</head>
<body>

	<!-- Include CSS -->
	<link href="css/bootstrap.css" rel="stylesheet">
	<link href="css/style.css" rel="stylesheet">
	<link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">
	<!-- Include Google font -->
	<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto:400,300,600">
	<!-- Include JavaScripts -->
	<script src="js/jquery-1.11.3.min.js"></script>
	<script src="js/bootstrap.js"></script>
	
	<?php if(!isset($showLogin)): echo($includes); ?>

	<div id="newUser" class="container">
		<div class="row">
		  	<div class="col-sm-offset-0 col-sm-12 col-md-10 col-md-offset-1">
		  	
		  		<?php if($DataSet == "DataSet_User"): ?>
				<h2 class="modal-header modal-title">First time setup <small>Let's start by creating a new user account!</small></h2>
				<?php else: ?>
				<h2 class="modal-header modal-title">First time setup <small>Great! Now let's configure some settings...</small></h2>
				<?php endif; ?>
		  		
				<form action="submit.php" method="post" name="firstSetup" id="firstSetup" autocomplete="off" data-entrytype="<?php echo($DataSet); ?>" data-entryid="<?php echo($entryData["UID"]); ?>" novalidate>
					<div class="modal-body">
						<?php echo($htmlData); ?>
					
						<div id="display_error" class="alert alert-danger fade in"></div>
					</div>
					
					<div class="modal-footer">
						<input type="submit" class="btn btn-lg btn-success" value="<?php if($DataSet == "DataSet_User"): echo("Next"); else: echo("Finish"); endif; ?>" id="submit">
					</div>
				</form>
				
		  	</div>
		</div>
	</div>
	<!-- /container -->
	
	<?php echo($jsData); ?>
	
	<script>
		
		$("#firstSetup").submit(function (e) {
			e.preventDefault();
			var obj = $(this);
			$("#firstSetup #display_error").hide().html("");
			console.log("Attempting Ajax Submit");
			$.ajax({
				type: "POST",
				url: e.target.action,
				data: obj.serialize()+"&Action=editEntry&entryID=" + obj.data("entryid") + "&entryType=" + obj.data("entrytype"),
				cache: false,
				success: function (JSONdata) {
					console.log(JSONdata);
					if (JSONdata.error != '') {
						var errors = "<ul>";
						JSONdata.error.forEach(function(elem){
							errors += "<li>";
							errors += elem;
							errors += "</li>";
						});
						errors += "</ul>";
						$("#firstSetup #display_error").show().html(errors);
					} else {
						location.reload();
					}
				},
				error: function ( jqXHR, textStatus, errorThrown){
					console.log(errorThrown);
					console.log(textStatus);
					console.log(jqXHR);
				}
			});
		});
		
		$(window).load(function(){
			
		});
		
	</script>
	<?php endif; if(isset($showLogin) && $showLogin): ?>
	
	<div id="login" class="container">
		<div class="row">
		  	<div class="col-sm-offset-0 col-sm-12 col-md-10 col-md-offset-1">
		  	
				<h2 class="modal-header modal-title">Your all set! <small>Go ahead and login to view your dashboard!</small></h2>
		  		
		  		<form action="submit.php" method="post" name="login_form" id="login_form" autocomplete="off" novalidate>
					<h3 class="form-signin-heading">Login</h3>

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
				
		  	</div>
		</div>
	</div>
	
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
	
	<?php endif; ?>
</body>
</html>