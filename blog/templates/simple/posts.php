<article class="<?php echo($post_status); ?>">
    <div class="row">
        <div class="one-quarter meta">
            <div class="thumbnail">
                <img src="<?php echo($post_image); ?>" alt="<?php echo($post['post_title']); ?>" />
            </div>

            <ul>
                <li>Written by <a href="<?php echo($post_author['url']); ?>"><?php echo($post['post_author']); ?></a></li>
                <li><?php echo($published_date); ?></li>
                <li>Categories: <?php foreach($post['post_categories_links'] as $key => $post_category_link): ?><a href="<?php echo($post_category_link); ?>"><?php
echo($post['post_categories'][$key]); ?></a>, <?php endforeach; ?></li>
                <li></li>
            </ul>
        </div>

        <div class="three-quarters post">
            <h2><a href="<?php echo($post['post_link']); ?>"><?php echo($post['post_title']); ?></a></h2>
			
           	<?php echo($used_posts) ?>
            <?php echo($post['post_intro']); ?>

            <ul class="actions">
                <li><a class="button" href="<?php echo($post['post_link']); ?>">Continue Reading</a></li>
                <?php if ($category) { ?>
                <li><a class="button" href="<?php echo($post['blog_url']); ?>">Back</a></li>
                <?php } ?>
            </ul>
        </div>
    </div>
</article>
