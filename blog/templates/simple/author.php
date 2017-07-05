<article class="author">
    <div class="row">
        <div class="one-quarter meta">
            <div class="thumbnail">
                <img src="<?php echo($author['avatar']); ?>" alt="<?php echo($author['name']); ?>" />
            </div>

            <ul>
                <li><a href="http://twitter.com/<?php echo($author['handle']); ?>">@<?php echo($author['handle']); ?></a></li>
                <li><?php echo($author['location']); ?></li>
                <li></li>
            </ul>
        </div>

        <div class="three-quarters post">
            <h2><?php echo($author['name']); ?></h2>
            <p><?php echo($author['about']); ?></p>
            <br>
            <?php foreach($author['posts'] as $post): ?>
            <p>
              <a href="<?php echo($post['post_link']);  ?>"><?php echo($post['post_title']); ?></a>
              <p class="meta" style="text-align: left;">
              <?php echo($post['post_date']); ?> 
              <?php foreach($post['post_categories_links'] as $key => $post_category_link): ?>
              <a href="<?php echo($post_category_link); ?>">
              	<?php echo($post['post_categories'][$key]); ?>
              </a>, 
              <?php endforeach; ?>
              </p>
            </p>
            <? endforeach ?>
        </div>


    </div>
</article>

