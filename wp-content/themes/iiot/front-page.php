<?php
/**
 * The template for displaying all pages
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site may use a
 * different template.
 */

get_header(); ?>

<div class="site-width content">
	<div class="home-content">
		<script src="<?php echo get_template_directory_uri(); ?>/inc/masonry.pkgd.min.js"></script>
		<script type="text/javascript">
		  jQuery(document).ready(function() {
		    jQuery('#foresite-link-column').masonry({ itemSelector: '.foresite-link', horizontalOrder: true });
		  });
		</script>

		<?php
		while ( have_posts() ) : the_post();
			the_content();
		endwhile;
		?>
	</div>

	<div class="home-blog">
		<a href="<?php echo home_url(); ?>/blog/" class="blog-home-link">Featured Articles</a>

		<?php
		$home_posts = get_posts(array('posts_per_page' => 3 ));
		foreach ($home_posts as $post) : setup_postdata($post);
			?>
			<a href="<?php echo get_permalink(); ?>" class="index-post">
  	    <div class="index-post-image" style="<?php echo (wp_get_attachment_url(get_post_thumbnail_id()) != "") ? "background-image: url(" . wp_get_attachment_url(get_post_thumbnail_id()) . ")" : "padding-top: 0; margin-bottom: 0;"; ?>"></div>

		    <?php
		    the_title('<h2>', '</h2>');

		    echo get_the_excerpt();
		    ?>
		  </a>
		  <?php
		endforeach;
    wp_reset_postdata();
		?>
	</div>
</div>

<img src="<?php echo get_template_directory_uri(); ?>/images/wifi.png" alt="" id="home-background">
<script type="text/javascript">
  jQuery(window).on('load resize', function(){
    jQuery('#home-background').height((jQuery('#foresite-link-column').height()/100)*80);
  });
</script>

<?php get_footer();
