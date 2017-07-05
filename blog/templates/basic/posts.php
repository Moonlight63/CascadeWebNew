<article class="post">
    <div class="row">
        <div class="one-quarter meta">
            <div class="thumbnail">
                <img src="<?php echo($entry["headerImg"]); ?>" alt="<?php echo($entry["name"]); ?>" />
            </div>

            <ul>
                <li>Written by <a href="<?php echo ($Settings["blogurl"]."/author/".(new DataSet_User)->get($entry["author"])["name"]); ?>"><?php echo ((new DataSet_User)->get($entry["author"])["displayName"]); ?></a></li>
                <li><?php echo($entry["publishdate"]); ?></li>
                <li>Categories: 
					<?php foreach(explode(",", $entry["tags"]) as $key): ?>
					<a href="<?php echo($Settings["blogurl"].'/category/'.urlencode(trim(strtolower($key)))); ?>"><?php echo($key); ?></a>, 
					<?php endforeach; ?>
                </li>
                <li></li>
            </ul>
		</div>

        <div class="three-quarters post">
            <h2><a href="<?php echo($Settings["blogurl"]."/post/".$entry["slug"]); ?>"><?php echo($entry["name"]); ?></a></h2>
			
            <?php echo(substr(strip_tags(html_entity_decode($entry["body"])), 0, 320)); ?>...

            <ul class="actions">
                <li><a class="button" href="<?php echo($Settings["blogurl"]."/post/".$entry["slug"]); ?>">Continue Reading</a></li>
                <?php if ($category) { ?>
                <li><a class="button" href="<?php echo($Settings["blogurl"]); ?>">Back</a></li>
                <?php } ?>
            </ul>
        </div>
    </div>
</article>
