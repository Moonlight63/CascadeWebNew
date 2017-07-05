<!DOCTYPE html>
<html lang="en">
    <head>
       
        <meta charset="utf-8">
        
        <title><?php echo($Settings["blogname"]); ?> | <?php echo($page_title); ?></title>
        
        <meta name="viewport" content="width=device-width, initial-scale=1">
        
        <link rel="stylesheet" href="<?php echo($blogFolder.$template_dir); ?>/style.css">
        <link rel="stylesheet" href="<?php echo($blogFolder.$template_dir); ?>/subdiv.css">
        <link href='https://fonts.googleapis.com/css?family=Merriweather:400,300,700' rel='stylesheet' type='text/css'>
        <link href='https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600' rel='stylesheet' type='text/css'>
        
    </head>

    <body>
        <article class="single not-found">
			<div class="row">
				<div class="one-quarter meta">
					<div class="thumbnail">
					</div>
				</div>
				
				<div class="three-quarters post">
					<h1>Sorry, But That's Not Here</h1>
					<p>'Really sorry, but what you're looking for isn't here. Click the button below to find something else that might interest you.</p>

					<ul class="actions">
						<li><a class="button" href="<?php echo($url.$blogFolder); ?>">More Articles</a></li>
					</ul>
				</div>
			</div>
		</article>
    </body>
</html>

   

   
   