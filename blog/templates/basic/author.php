<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        
        <title><?php echo($Settings["blogname"]); ?> | <?php echo($page_title); ?></title>
        
        <?php echo($page_meta); ?>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        
        <link rel="stylesheet" href="<?php echo($blogFolder.$template_dir); ?>/style.css">
        <link rel="stylesheet" href="<?php echo($blogFolder.$template_dir); ?>/subdiv.css">
        <link href='https://fonts.googleapis.com/css?family=Merriweather:400,300,700' rel='stylesheet' type='text/css'>
        <link href='https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600' rel='stylesheet' type='text/css'>
        <?php get_header(); ?>
    </head>

    <body>
       
       <article class="author">
			<div class="row">
				<div class="one-quarter meta">
					<div class="thumbnail">
						<img src="<?php echo($author['avatar']); ?>" alt="<?php echo($author['displayName']); ?>" />
					</div>

					<ul>
						<li><a href="http://twitter.com/<?php echo($author['name']); ?>">@<?php echo($author['name']); ?></a></li>
						<li><?php echo($author['role']); ?></li>
						<li></li>
					</ul>
				</div>

				<div class="three-quarters post">
					<h2><?php echo($author['displayName']); ?></h2>
					<p><?php echo($author['about']); ?></p>
					<br>
				</div>


			</div>
		</article>
        
        <div id="allpageposts">
       		<?php echo($markup); ?>
       	</div>
       	
        <?php get_footer(); ?>
    </body>
</html>