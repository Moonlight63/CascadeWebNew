<?php

/*-----------------------------------------------------------------------------------*/
/* Include 3rd Party Functions
/*-----------------------------------------------------------------------------------*/

// Display errors if there are any.

include_once(__DIR__ . '/feedwriter.php');
include_once(__DIR__ . '/settings.php');


/*-----------------------------------------------------------------------------------*/
/* Post Pagination
/*-----------------------------------------------------------------------------------*/

function get_pagination($page,$total) {

    $string = '';
    $string .= "<ul style=\"list-style:none; width:400px; margin:15px auto;\">";

    for ($i = 1; $i<=$total;$i++) {
        if ($i == $page) {
            $string .= "<li style='display: inline-block; margin:5px;' class=\"active\"><a class=\"button\" href='#'>".$i."</a></li>";
        } else {
            $string .=  "<li style='display: inline-block; margin:5px;'><a class=\"button\" href=\"?page=".$i."\">".$i."</a></li>";
        }
    }

    $string .= "</ul>";
    return $string;
}

/*-----------------------------------------------------------------------------------*/
/* Header
/*-----------------------------------------------------------------------------------*/

function get_header() { ?>
    <!-- RSS Feed Links -->
    <link rel="alternate" type="application/rss+xml" title="Subscribe using RSS" href="<?php echo BLOG_URL; ?>rss" />
    <link rel="alternate" type="application/atom+xml" title="Subscribe using Atom" href="<?php echo BLOG_URL; ?>atom" />

    <!-- Styles -->
    <link rel="stylesheet" href="<?php echo BLOG_URL; ?>/dropplets/style/style.css">
    <link rel="shortcut icon" href="<?php echo BLOG_URL; ?>/dropplets/style/images/favicon.png">

<?php

}

/*-----------------------------------------------------------------------------------*/
/* Footer
/*-----------------------------------------------------------------------------------*/

function get_footer() { ?>
    <script src="<?php echo(BLOG_FOLDER); ?>admin/js/jquery.query-object.js"></script>
    <script>		
		var infinite = true;
        var next_page = <?php echo(((isset($_GET['page']) && is_numeric($_GET['page']) && $_GET['page'] > 1) ? $_GET['page'] : 1) + 1); ?>;;
        var loading = false;
        var no_more_posts = false;
        $(function() {
            function load_next_page() {
				var qstring = $.query.set("page", next_page).toString();
                $.ajax({
                    url: qstring,
                    success: function (res) {
                        next_page++;
                        var result = $.parseHTML(res);
						var articles = $(result).find('div#allpageposts').find('article.post:not(.single)');
                        if (articles.length < 1) {
                            no_more_posts = true;
                        }  else {
							$('div#allpageposts').append(articles);
                        }
                        loading = false;
                    }
                });
            }
			
			function checkScroll(){
				var dist_from_bottom = $(document).height() - (window.innerHeight + $(window).scrollTop());
				
				if($(window).scrollTop() == 0 && dist_from_bottom == 0){
					loading = true;
                    setTimeout(load_next_page,10);
				}
				console.log(dist_from_bottom);
				if (infinite && (loading != true && !no_more_posts) && dist_from_bottom <= 200 ) {
                    // Sometimes the scroll function may be called several times until the loading is set to true.
                    // So we need to set it as soon as possible
                    loading = true;
                    setTimeout(load_next_page,10);
                }
			}

            $(window).scroll(function() {
                checkScroll();
            });
			checkScroll();
        });
    </script>
<?php

}
