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
        <link href='https://cdnjs.cloudflare.com/ajax/libs/froala-editor/2.5.0/css/froala_style.css' rel='stylesheet' type='text/css'>
        <?php //get_header(); ?>
    </head>

    <body>
       	<div id="allpageposts">
       		<?php echo($markup); ?>
       	</div>
       	
        <?php get_footer(); ?>
    </body>
</html>
