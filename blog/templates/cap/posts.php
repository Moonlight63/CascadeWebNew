<article class="post container">
    <div class="row">
     	
     	<?php if(isset($entry["headerImg"]) && $entry["headerImg"] != ""):
		$mainclasses = "col-md-7 col-md-offset-1 col-sm-8 col-xs-12 col-sm-pull-4 col-md-pull-3";
		?>
      	
      	<div class="col-md-3 col-xs-9 col-xs-offset-1 col-sm-4 col-sm-push-8 col-sm-offset-0">
       		<div class="thumbnail">
                <img src="<?php echo($entry["headerImg"]); ?>" alt="<?php echo($entry["name"]); ?>" />
            </div>
       	</div>
       	
       	<?php else:
		$mainclasses = "col-md-10 col-md-offset-1 col-sm-12 col-xs-12";
      	endif;
		?>
       	<div class="<?php echo($mainclasses); ?>">
       	
       		<div class="posttitle">
       			<h2><a href="<?php echo($Settings["blogurl"]."/post/".$entry["slug"]); ?>"><?php echo($entry["name"]); ?></a></h2>
			</div>
      		<div class="postinfo">
      		
      			<ul class="list-inline">
      				
      				<li><small><strong>Written by</strong> <a href="<?php echo ($Settings["blogurl"]."/author/".(new DataSet_User)->get($entry["author"])["name"]); ?>"><?php echo ((new DataSet_User)->get($entry["author"])["displayName"]); ?></a></small></li>
      				
      				<li><small><strong>Published:</strong> <?php echo(DataSet_Base::dateTimeFromString($entry["publishdate"])->format('F jS, Y h:iA')); ?></small></li>
      				
      				<?php if(!empty($entry["tags"])): ?>
      				<li><small>
					<strong>Categories:</strong> <?php foreach(explode(",", $entry["tags"]) as $key): ?>	<a href="<?php echo($Settings["blogurl"].'/category/'.urlencode(trim(strtolower($key)))); ?>"><?php echo($key); ?></a>, <?php endforeach; ?>
					</small></li>
					<?php endif; ?>
      				
      			</ul>
      			
      		</div>
      		<div class="postbody">
      			<?php echo(substr(strip_tags(html_entity_decode($entry["body"])), 0, 320)); ?>...
      		</div>
      		<div class="postactions" style="margin-top: 20px">
      			<ul class="actions list-inline">
					<li><a class="btn btn-outline btn-primary btn-lg" href="<?php echo($Settings["blogurl"]."/post/".$entry["slug"]); ?>">Continue Reading</a></li>
					<?php if ($category) { ?>
					<li><a class="btn btn-outline btn-primary btn-lg" href="<?php echo($Settings["blogurl"]); ?>">Back</a></li>
					<?php } ?>
				</ul>
      		</div>
       	</div>
       
    </div>
</article>
