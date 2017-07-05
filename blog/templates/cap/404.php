<!DOCTYPE html>
<html lang="en">
    <head>
       
       <meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title><?php echo($Settings["blogname"]); ?> | <?php echo($page_title); ?></title>
		<!-- Bootstrap -->
		<link rel="stylesheet" href="<?php echo($blogFolder); ?>../css/bootstrap.css">
		<link rel="stylesheet" href="<?php echo($blogFolder); ?>../css/font-awesome.css">
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/hover.css/2.1.0/css/hover-min.css">
		<link rel="stylesheet" href="<?php echo($blogFolder); ?>../css/push-menu.css">
		<link rel="icon" type="image/png" href="<?php echo($blogFolder); ?>../img/Logo_Vector_Black2.png">

		<!--LightGallery-->
		<link rel="stylesheet" href="<?php echo($blogFolder); ?>../css/lightgallery.min.css" type="text/css"/>
		<link rel="stylesheet" href="<?php echo($blogFolder); ?>../css/siteglobal.css"/>
		
		<script type='application/ld+json'> 
		{
			"@context": "http://www.schema.org",
			"@type": "LocalBusiness",
			"name": "Cascade Aerial Photography",
			"url": "http://cascadeap.com/",
			"telephone": "+1(253)-888-0499",
			"email": "contact@cascadeap.com",
			"priceRange": "$$$",
			"sameAs": [
				"http://www.cascadeap.com/",
				"http://www.cascadeaerialphotography.com/",
				"http://cascadeaerialphotography.com/"
			],
			"logo": "http://cascadeap.com/img/logo.jpg",
			"image": "http://cascadeap.com/img/logo.jpg",
			"description": "Cascade Aerial Photography is one of the first in the pacific northwest to carry all required FAA certifications and to be fully compliant with all of the new UAS operating regulations. Safety is always our number one priority on any operation. All of our flights are fully insured to protect the safety and property of our clients. By utilizing the latest, state-of-the-art camera and flight stabilization technologies, we are working with our clients to provide them with a new perspective that helps them achieve their goals more efficiently. Whether it's cinema, events, weddings, real-estate, advertising, inspection, or something else entirely, Cascade may have a solution for you. Contact us to find out!",
			"address": {
				"@type": "PostalAddress",
				"streetAddress": "2523 Pacific Hwy E, Suite D",
				"addressLocality": "Fife",
				"addressRegion": "Washington",
				"postalCode": "98424",
				"addressCountry": "USA"
			},
			"geo": {
				"@type": "GeoCoordinates",
				"latitude": "47.24519999",
				"longitude": "-122.39538932"
			},
			"contactPoint": {
				"@type": "ContactPoint",
				"telephone": "+1(253)-888-0499",
				"email": "contact@cascadeap.com",
				"contactType": "customer service"
			},
			"contactPoint": {
				"@type": "ContactPoint",
				"telephone": "+1(253)-888-0499",
				"email": "contact@cascadeap.com",
				"contactType": "sales"
			}
		}
		</script>
        
        <!--<link rel="stylesheet" href="<?php echo($blogFolder.$template_dir); ?>/style.css">
        <link rel="stylesheet" href="<?php echo($blogFolder.$template_dir); ?>/subdiv.css">-->
        <link rel="stylesheet" href="<?php echo($blogFolder.$template_dir); ?>/blogstyle.css">
        <link href='https://fonts.googleapis.com/css?family=Merriweather:400,300,700' rel='stylesheet' type='text/css'>
        <link href='https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600' rel='stylesheet' type='text/css'>
        <link href='https://cdnjs.cloudflare.com/ajax/libs/froala-editor/2.5.0/css/froala_style.css' rel='stylesheet' type='text/css'>
        
        <style>
		.btn-outline {
			background-color: transparent;
			color: inherit;
			transition: all .5s;
		}
		.btn-primary.btn-outline {
			color: #428bca;
		}
		.btn-success.btn-outline {
			color: #5cb85c;
		}
		.btn-info.btn-outline {
			color: #5bc0de;
		}
		.btn-warning.btn-outline {
			color: #f0ad4e;
		}
		.btn-danger.btn-outline {
			color: #d9534f;
		}
		.btn-primary.btn-outline:hover,
		.btn-success.btn-outline:hover,
		.btn-info.btn-outline:hover,
		.btn-warning.btn-outline:hover,
		.btn-danger.btn-outline:hover {
			color: #fff;
		}
		</style>
        
        <?php echo($page_meta); ?>
        
        <?php //get_header(); ?>
    </head>

    <body>
      	
      	<script src="<?php echo($blogFolder); ?>../js/jquery-1.11.3.min.js"></script>
		<script src="<?php echo($blogFolder); ?>../js/bootstrap.js"></script>
		<script src="<?php echo($blogFolder); ?>../js/push-menu.js"></script>
     	
     	
     	<div class="topnav">
			<img src="<?php echo($blogFolder); ?>../img/logo_vector_white.svg" alt="Logo" class="topnavlogo"/>
			<div class="topnavtglbtn visible-xs">
				<button type="button" data-toggle="push" data-target="#mainnavlinks" data-direction="right" aria-expanded="false"> 
					<span class="sr-only">Toggle navigation</span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</button>
			</div>
			<div id="mainnavlinks" class="topnavlinks">
				<ul>
					<li role="presentation"><a href="<?php echo($blogFolder); ?>../index.html"><i class="fa fa-home" aria-hidden="true"></i> Home</a></li>
					<li role="presentation"><a href="<?php echo($blogFolder); ?>../about.html"><i class="fa fa-user" aria-hidden="true"></i> About</a></li>
					<li role="presentation"><a href="<?php echo($blogFolder); ?>../services.html"><i class="fa fa-tasks" aria-hidden="true"></i> Services</a></li>
					<li role="presentation"><a href="<?php echo($blogFolder); ?>../gallery.html"><i class="fa fa-camera" aria-hidden="true"></i> Gallery</a></li>
					<li role="presentation"><a href="<?php echo($blogFolder); ?>../contact.html"><i class="fa fa-envelope-open" aria-hidden="true"></i> Contact</a></li>
				</ul>
			</div>
		</div>
    	
    	<div id="pagecontent">
    	
    		<section class="headcontent">
				<div style="display: inline-block; max-width: 100vw; width: 100%; height:auto; padding-bottom: 50px;">
					<div class="sectiontitle" style="display: block; margin-left: 50%; transform: translateX(-50%); margin-top: 150px; margin-bottom: 50px;">
						<h2>404</h2>
					</div>
				</div>
			</section>
    	
			<section class="maincontent">
				<article class="post container single">
					<div class="row">
						<div class="col-md-10 col-md-offset-1 col-sm-12 col-xs-12">
							<div class="posttitle">
								<h2>Sorry, But That's Not Here</h2>
							</div>
							<div class="postbody">
								<p>Really sorry, but what you're looking for isn't here. Click the button below to find something else that might interest you.</p>
							</div>
							<div class="postactions" style="margin-top: 20px">
								<ul class="actions list-inline">
									<li><a class="btn btn-outline btn-primary btn-lg" href="<?php echo($Settings["blogurl"]); ?>">More Articles</a></li>
								</ul>
							</div>
						</div>

					</div>
				</article>
			</section>
		</div>
     	
      	
		<footer class="footer">
			<div class="footercont1">
				<div class="footerlinks">
					<div class="footerlink hvr-float">
						<a>
							<i class="fa fa-facebook-official" aria-hidden="true"></i>
						</a>
					</div>
					<div class="footerlink hvr-float">
						<a>
							<i class="fa fa-twitter" aria-hidden="true"></i>
						</a>
					</div>
					<div class="footerlink hvr-float">
						<a href="#">
							<i class="fa fa-youtube-play" aria-hidden="true"></i>
						</a>
					</div>
					<div class="footerlink hvr-float">
						<a href="#" class="backToTop">
							<i class="fa fa-chevron-up" aria-hidden="true"></i>
						</a>
					</div>
				</div>
			</div>
			<div class="footercont2">
				<p class="footercopy text-center text-muted">All Content © Cascade Aerial Photography, 2017. All Rights Reserved.</p>
			</div>
		</footer>
		
		<script>
		jQuery(document).ready(function() {
			jQuery('.backToTop').click(function(event) {
				event.preventDefault();
				jQuery('html, body').animate({scrollTop: 0}, 1000);
				return false;
			});
		});
		</script>
       	
        <?php get_footer(); ?>
    </body>
</html>

   

   
   