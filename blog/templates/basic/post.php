<article class="single">
    <div class="row">
        <div class="one-quarter meta">
            <div class="thumbnail">
                <img src="<?php echo($post['headerImg']); ?>" alt="<?php echo($post['name']); ?>" />
            </div>

            <ul>
                <li>Written by <a href="<?php echo ($Settings["blogurl"]."/author/".(new DataSet_User)->get($post["author"])["name"]); ?>"><?php echo ((new DataSet_User)->get($post["author"])["displayName"]); ?></a></li>
                
                <li>Published: <?php echo( DataSet_Base::dateTimeFromString($post["publishdate"])->format('F jS, Y h:iA') ); ?></li>
                
                <?php if(isset($post["lastedited"])): ?>
                <li>Edited: <?php echo( DataSet_Base::dateTimeFromString($post["lastedited"])->setTimezone(DataSet_Base::dateTimeFromString($post["publishdate"])->getTimezone())->format('F jS, Y h:iA') ); ?></li>
                <?php endif; ?>
                
                <?php if(isset($post["tags"]) && !empty($post["tags"])): ?>
                <li>Categories: 
                	<?php foreach(explode(",", $post["tags"]) as $key): ?>
					<a href="<?php echo($Settings["blogurl"].'/category/'.urlencode(trim(strtolower($key)))); ?>"><?php echo($key); ?></a>, 
					<?php endforeach; ?>
                </li>
                <?php endif; ?>
                <li></li>
            </ul>
        </div>

        <div class="three-quarters post">
            <h2><?php echo($post["name"]); ?></h2>
            
            <div class="fr-view">
            	<?php echo(html_entity_decode($post['body'])); ?>
            </div>            

            <ul class="actions">
                <li><a class="button" href="<?php echo($Settings["blogurl"]); ?>">Back</a></li>
            </ul>
        </div>
    </div>
</article>
