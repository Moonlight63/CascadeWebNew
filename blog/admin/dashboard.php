<?php

require(__DIR__ . '/inc/functions.php');
require_once("DatasetAPI/datasets.php");
use Opis\Closure\SerializableClosure;
session_start();
/*Check for authentication otherwise user will be redirects to main.php page.*/
if (!isset($_SESSION['UserData'])) {
    exit(header("location:login.php"));
}

?>
<!doctype html>
<html>
<head>
	<meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
	<title>Blog Dashboard</title>
</head>
<body>

	<nav class="navbar navbar-default">
		<div class="container-fluid"> 
			<!-- Brand and toggle get grouped for better mobile display -->
			<div class="navbar-header">
				<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#defaultNavbar1">
					<span class="sr-only">Toggle navigation</span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</button>
				<a class="navbar-brand" href="#"><?php echo($_SESSION["UserData"]["displayName"]); ?> | Blog Dashboard</a>
			</div>

			<!-- Collect the nav links, forms, and other content for toggling -->
			<div class="collapse navbar-collapse" id="defaultNavbar1">
				<ul class="nav navbar-nav">
					<li class="<?php echo($_GET['section'] == 'posts' ? "active " : "");?>navBtn"><a href="?section=posts">Posts</a></li>
					<?php if($_SESSION["UserData"]["role"] == "admin"){ ?>
					<li class="<?php echo($_GET['section'] == 'users' ? "active " : "");?>navBtn"><a href="?section=users">Users</a></li>
					<?php }else{ ?>
					<li class="<?php echo($_GET['section'] == 'editmydetails' ? "active " : "");?>navBtn"><a href="?section=editmydetails">My Info</a></li>
					<?php } ?>
					<?php if($_SESSION["UserData"]["role"] == "admin"){ ?>
					<li class="<?php echo($_GET['section'] == 'editsettings' ? "active " : "");?>navBtn"><a href="?section=editsettings">Blog Settings</a></li>
					<?php } ?>
					<li class="<?php echo($_GET['section'] == 'logout' ? "active " : "");?>navBtn"><a href="?section=logout"><?php if(isset($_SESSION["True_UserData"])){ ?>Logout of User<?php }else{ ?>Logout<?php } ?></a></li>
					
				</ul>
				<form class="navbar-form navbar-right" id="searchForm" role="search">
					<div class="form-group">
						<input type="text" id="searchQuery" class="form-control" placeholder="Search">
					</div>
					<button type="submit" class="btn btn-default">Search</button>
				</form>
			</div>
		</div>
	</nav>
	
	
	<!-- Include CSS -->
	<link href="css/bootstrap.css" rel="stylesheet"><!-- Bootstrap CSS -->
	<link href="css/style.css" rel="stylesheet"><!-- Custom CSS -->
	<link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">
	<!-- Include Google font -->
	<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto:400,300,600">
	<!-- Include JavaScripts -->
	<script src="js/jquery-1.11.3.min.js"></script><!-- Load jquery -->
	<script src="js/bootstrap.js"></script><!-- Load bootstrap js -->
	<script src="js/jquery.query-object.js"></script>
	
	<style>
		.notPublished{
			background-color: #f9e9e9;
		}
		.notPublished:hover{
			background-color: #f9e5e5 !important;
		}
	</style>
	
	
	<?php if(!isset($_GET['section'])){ exit(header("location:?section=posts"));}?>
	<?php if($_GET['section'] == 'posts'){
	
		$DataSet = "DataSet_Post";
		unset($_SESSION["DatasetInfo"]);
		$_SESSION["DatasetInfo"] = ["DataSet" => $DataSet];
	
		$getPublished = new SerializableClosure(function($publishDate){
			if(isset($publishDate) && $publishDate != "" && DataSet_Base::normalizeDateTime(DataSet_Base::dateTimeFromString($publishDate)) <= DataSet_Base::normalizeDateTime(new DateTime())){
				return " published";
			}
			return " notPublished";
		});

		$_SESSION["DatasetInfo"]["Feedback"] = ["publishdate" => $getPublished];
	
		if($_SESSION["UserData"]["role"] == "author"){
			$_SESSION["DatasetInfo"]["SearchQueries"] = ["author" => $_SESSION["UserData"]["UID"]];
		}
	
	?>
	
	<div class="container-fluid">
		<div class="row">
			<div class="col-sm-offset-1 col-sm-10 col-md-8 col-md-offset-2">
		
				<button type="button" class="btn btn-default btn-lg btn_createPost" style="margin-bottom: 10px">
					+ Create New Post
				</button>
				
				<table class="table table-hover pageTable">
					<tbody>
						<?php 
						include('./getEntrys.php');
						?>
					</tbody>
				</table>
				
			</div>
		</div>
	</div>
	
	<?php } ?>
	
	<?php if($_GET['section'] == 'editposts'){
		$externalLoad = true;
		$DataSet = "DataSet_Post";
	
		unset($_SESSION["DatasetInfo"]);
		$_SESSION["DatasetInfo"] = ["DataSet" => $DataSet, "CloseLink" => "./dashboard.php?section=posts"];
	
		include("editEntry.php");
	} ?>
	
	
	
	<?php if($_GET['section'] == 'users'){
	
		if ($_SESSION['UserData']['role'] != "admin") {
			exit(header("location:?section=editmydetails&userID=".$_SESSION['UserData']['user_name']));
		}
	
		$DataSet = "DataSet_User";
		unset($_SESSION["DatasetInfo"]);
		$_SESSION["DatasetInfo"] = ["DataSet" => $DataSet];
	
	?>
	
	<div class="container-fluid">
		<div class="row">
			<div class="col-sm-offset-1 col-sm-10 col-md-8 col-md-offset-2">
		
				<button type="button" class="btn btn-default btn-lg btn_createUser" style="margin-bottom: 10px">
					+ Create New User
				</button>
				
				<table class="table table-hover pageTable">
					<tbody>
						<?php 
						include('./getEntrys.php');
						?>
					</tbody>
				</table>
				
			</div>
		</div>
	</div>
	
	<?php } ?>
	
	
	<?php 
	if($_GET['section'] == 'editsettings'){
		
		if ($_SESSION['UserData']['role'] != "admin") {
			exit(header("location:?section=editmydetails&userID=".$_SESSION['UserData']['user_name']));
		}
		
		if (!isset($_GET['entryID']) || ($_GET['entryID'] != "settings")) {
			exit(header("location:?section=editsettings&entryID=settings"));
		}
		
		$externalLoad = true;
		$DataSet = "DataSet_Settings";
	
		unset($_SESSION["DatasetInfo"]);
		$_SESSION["DatasetInfo"] = ["DataSet" => $DataSet, "CloseLink" => "./dashboard.php?section=posts"];
	
		include("editEntry.php");
	}
	?>
	
	
	<?php if($_GET['section'] == 'editusers'){
		$externalLoad = true;
		$DataSet = "DataSet_User";
	
		unset($_SESSION["DatasetInfo"]);
		$_SESSION["DatasetInfo"] = ["DataSet" => $DataSet, "CloseLink" => "./dashboard.php?section=users"];
	
		include("editEntry.php");
	} ?>
	
	
	
	
	
	
	<?php 
	if($_GET['section'] == 'editmydetails'){
		if (!isset($_GET['entryID']) || ($_GET['entryID'] != $_SESSION['UserData']['name'] && $_GET['entryID'] != $_SESSION['UserData']['UID'])) {
			exit(header("location:?section=editmydetails&entryID=".$_SESSION['UserData']['UID']));
		}
		
		$externalLoad = true;
		$DataSet = "DataSet_User";
	
		unset($_SESSION["DatasetInfo"]);
		$_SESSION["DatasetInfo"] = ["DataSet" => $DataSet, "CloseLink" => "./dashboard.php?section=editmydetails"];
	
		include("editEntry.php");
	}
	?>
	
	<?php if($_GET['section'] == 'notes'){
	
		$DataSet = "DataSet_Note";
		unset($_SESSION["DatasetInfo"]);
		$_SESSION["DatasetInfo"] = ["DataSet" => $DataSet];
	
	?>
	
	<div class="container-fluid">
		<div class="row">
			<div class="col-sm-offset-1 col-sm-10 col-md-8 col-md-offset-2">
		
				<button type="button" class="btn btn-default btn-lg btn_createNote" style="margin-bottom: 10px">
					+ Create New Note
				</button>
				
				<table class="table table-hover pageTable">
					<tbody>
						<?php 
						include('./getEntrys.php');
						?>
					</tbody>
				</table>
				
			</div>
		</div>
	</div>
	
	<?php } ?>
	
	<?php if($_GET['section'] == 'editnotes'){
		$externalLoad = true;
		$DataSet = "DataSet_Note";
	
		unset($_SESSION["DatasetInfo"]);
		$_SESSION["DatasetInfo"] = ["DataSet" => $DataSet, "CloseLink" => "./dashboard.php?section=notes"];
	
		include("editEntry.php");
	} ?>
	
	<?php 
	if($_GET['section'] == 'logout'){
		if(isset($_SESSION["True_UserData"])){
			$_SESSION["UserData"] = $_SESSION["True_UserData"];
			unset($_SESSION["True_UserData"]);
			exit(header("location:dashboard.php?section=users"));
		}else{
			session_destroy(); /* Destroy started session */
			exit(header("location:login.php"));
		}
	}
	?>
	
	<?php 
	// Do we need infinity scroll?
	
	$infiniscroll = false;
	//$getURL = 'none';
	switch ($_GET['section']) {
		case 'posts' :
			$infiniscroll = true;
			break;
		case 'users' :
			$infiniscroll = true;
			break;
		case 'notes' :
			$infiniscroll = true;
			break;
		default :
			break;
	}
	
	
	if($infiniscroll){
	?>
	
	<script>
        var infinite = true;
        var next_page = <?php echo(((isset($_GET['page']) && is_numeric($_GET['page']) && $_GET['page'] > 1) ? $_GET['page'] : 1) + 1); ?>;;
        var loading = false;
        var no_more_posts = false;
        $(function() {
            function load_next_page() {
				console.log("loading next Page");
				var qstring = $.query.set("page", next_page).toString();
                $.ajax({
                    url: './getEntrys.php' + qstring,
                    success: function (res) {
                        next_page++;
                        var result = $.parseHTML(res);
                        var articles = $(result).filter(function() {
							console.log(this);
                            return $(this).is('tr.pageItem');
                        });
						//var articles = $(result).find('table.pageTable > tbody').find('tr.pageItem');
						console.log(articles);
                        if (articles.length < 1) {
                            no_more_posts = true;
                        }  else {
							$('.pageTable tbody').append(articles);
                        }
                        loading = false;
                    }
                });
            }
			
			function checkScroll(){
				var dist_from_bottom = $(document).height() - (window.innerHeight + $(window).scrollTop());
				
				if($(window).scrollTop() == 0 && dist_from_bottom == 0){
					loading = true;
                    setTimeout(load_next_page,10);
				}
				console.log(dist_from_bottom);
				if (infinite && (loading != true && !no_more_posts) && dist_from_bottom <= 200 ) {
                    // Sometimes the scroll function may be called several times until the loading is set to true.
                    // So we need to set it as soon as possible
                    loading = true;
                    setTimeout(load_next_page,10);
                }
			}

            $(window).scroll(function() {
                checkScroll();
            });
			checkScroll();
        });		
		
		$("#searchForm").submit(function(e){
			e.preventDefault();
			var url = [location.protocol, '//', location.host, location.pathname].join('');
			url += $.query.set("search", $("#searchQuery").val()).toString();
			location.href = url;
		});
		
		$(".pageTable > tbody").on("click", ".entryEdit", function(){
			location.href = $.query.set("entryID", $(this).data("link")).set("section", "edit" + $.query.get("section"));
		});
    </script>
    
	<?php
	}
	?>
	
	
	<?php if($_GET['section'] == 'users'){	?>
	
	<script>
		
		$(".btn_createUser").on("click", function(){
			window.location.href = "./dashboard.php?section=editusers";
		});	
		
//		$(".entryEdit").on("click", function(){
//			window.location.href = "?section=edituser&entryID=" + $(this).data("link");
//		});
		
	</script>
	
	<?php
	}
	?>
	
	
	<?php if($_GET['section'] == 'posts'){	?>
	
	<script>
		
		$(".btn_createPost").on("click", function(){
			window.location.href = "./dashboard.php?section=editposts";
		});	
		
//		$(".entryEdit").on("click", function(){
//			window.location.href = "?section=editpost&entryID=" + $(this).data("link");
//		});
		
		
//		$(".postDelete").on("click", function(){
//			console.log("Test");
//			if(confirm("Are you sure? This will Permenatly delete this post and all of it's assets. Items cannot be recovered!")){
//				$.ajax({
//					type: "POST",
//					url: "submit.php",
//					data: "Action=delete_post&postID=" + $(this).data("link"),
//					cache: false,
//					success: function (JSON) {
//						console.log(JSON);
//						$("#"+JSON.result).remove();
//					},
//					error: function ( jqXHR, textStatus, errorThrown){
//						console.log(errorThrown);
//						console.log(textStatus);
//						console.log(jqXHR);
//					}
//				});
//			}
//		});
		
	</script>
	
	<?php
	}
	?>
	
	<?php if($_GET['section'] == 'notes'){	?>
	
	<script>		
		$(".btn_createNote").on("click", function(){
			window.location.href = "./dashboard.php?section=editnotes";
		});	
		
//		$(".entryEdit").on("click", function(){
//			window.location.href = "?section=editnote&entryID=" + $(this).data("link");
//		});
	</script>
	
	<?php
	}
	?>
	
</body>
</html>