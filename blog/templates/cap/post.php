<article class="post container single">
    <div class="row">
       	<div class="col-md-10 col-md-offset-1 col-sm-12 col-xs-12">
       	
       		<?php if(isset($post["headerImg"]) && $post["headerImg"] != ""): ?>
			<div class="thumbnail postimg">
				<img src="<?php echo($post["headerImg"]); ?>" alt="<?php echo($post["name"]); ?>" />
			</div>
			<?php endif; ?>
       	
       		<div class="posttitle">
       			<h2><?php echo($post["name"]); ?></h2>
			</div>
      		<div class="postinfo">
      		
      			<ul class="list-inline">
      				
      				<li><small><strong>Written by</strong> <a href="<?php echo ($Settings["blogurl"]."/author/".(new DataSet_User)->get($post["author"])["name"]); ?>"><?php echo ((new DataSet_User)->get($post["author"])["displayName"]); ?></a></small></li>
      				
      				<li><small><strong>Published:</strong> <?php echo(DataSet_Base::dateTimeFromString($post["publishdate"])->format('F jS, Y h:iA')); ?></small></li>
      				
      				<?php if(isset($post["lastedited"])): ?>
					<li><small><strong>Edited:</strong> <?php echo( DataSet_Base::dateTimeFromString($post["lastedited"])->setTimezone(DataSet_Base::dateTimeFromString($post["publishdate"])->getTimezone())->format('F jS, Y h:iA') ); ?></small></li>
					<?php endif; ?>
      				
      				<?php if(!empty($post["tags"])): ?>
      				<li><small>
					<strong>Categories:</strong> <?php foreach(explode(",", $post["tags"]) as $key): ?>	<a href="<?php echo($Settings["blogurl"].'/category/'.urlencode(trim(strtolower($key)))); ?>"><?php echo($key); ?></a>, <?php endforeach; ?>
					</small></li>
					<?php endif; ?>
      				
      			</ul>
      			
      		</div>
      		<div class="postbody">
      			<?php echo(html_entity_decode($post['body'])); ?>
      		</div>
      		
      		<div class="postactions" style="margin-top: 20px">
      			<ul class="actions list-inline">
					<li><a class="btn btn-outline btn-primary btn-lg" href="<?php echo($Settings["blogurl"]); ?>">Back</a></li>
				</ul>
      		</div>
       	</div>
       
    </div>
</article>
