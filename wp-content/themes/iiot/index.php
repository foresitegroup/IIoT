<?php
if (is_single()) :
  // the_post();
  $BlogInc = '
  <meta property="og:title" content="'.get_the_title().'" />
  <meta property="og:image" content="'.wp_get_attachment_url(get_post_thumbnail_id()).'" />
  <meta property="og:url" content="'.get_permalink().'" />
  <meta name="twitter:card" content="summary_large_image">
  <meta name="twitter:title" content="'.get_the_title().'">
  <meta name="twitter:description" content="'.get_the_excerpt().'">
  <meta name="twitter:image" content="'.wp_get_attachment_url(get_post_thumbnail_id()).'">
  ';
endif;

get_header(); ?>

<div class="site-width">
	<?php if (!is_single()) : ?>

	  <div class="blog-index">
	  	<h1 class="blog-title">Blog Index</h1>

	  	<?php while (have_posts()) : the_post(); get_template_part('content'); endwhile; ?>

	  	<script type="text/javascript">
	  		jQuery(window).on("load",function(){
          jQuery(".index-post").hide();
          jQuery(".index-post").slice(0, 6).show();

          // Don't show button if fewer than max number of posts
          if (jQuery(".index-post:hidden").length == 0) jQuery("#loadmore").fadeOut('fast');

          jQuery("#loadmore").on('click', function (e) {
            e.preventDefault();
            jQuery(".index-post:hidden").slice(0, 6).slideDown();

            // Remove button when we get to the end of the posts
            if (jQuery(".index-post:hidden").length == 0) jQuery("#loadmore").fadeOut('slow');
          });
        });
	  	</script>

	  	<div class="loadmore">
        <a href="#" id="loadmore">Load More</a>
      </div>
		</div>

	<?php else : ?>

		<div class="blog-single">
			<a href="<?php echo home_url(); ?>/blog/" class="blog-home-link">Return To Index</a>

	    <?php while (have_posts()) : the_post(); get_template_part('content'); endwhile; ?>
	  </div>

	<?php endif; ?>
</div>

<?php get_footer(); ?>