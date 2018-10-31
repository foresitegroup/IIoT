<?php
/*
Plugin Name: Foresite Links
Plugin URI: https://foresitegrp.com
Description: Create posts consisting solely of linked text.
Version: 1.0
Author: Foresite Group
Author URI: https://foresitegrp.com
*/

add_action( 'init', 'foresite_link' );
function foresite_link() {
  register_post_type( 'foresite_link',
    array(
      'labels' => array(
        'name' => 'Links',
        'singular_name' => 'Link',
        'add_new' => 'Add New',
        'add_new_item' => 'Add New Link',
        'edit' => 'Edit',
        'edit_item' => 'Edit Link',
        'new_item' => 'New Link',
        'view' => 'View',
        'view_item' => 'View Link',
        'search_items' => 'Search Links',
        'not_found' => 'No Links found',
        'not_found_in_trash' => 'No Links found in Trash',
        'parent' => 'Parent Link'
      ),

      'public' => false,
      'show_ui' => true,
      'show_in_menu' => true,
      'menu_position' => 5,
      'supports' => array( 'title' ),
      'taxonomies' => array( '' ),
      'menu_icon' => 'dashicons-admin-links',
      'has_archive' => true
    )
  );
}


add_action( 'admin_init', 'foresite_link_admin' );
function foresite_link_admin() {
  add_meta_box( 'foresite_link_meta_box',
    'Link URL',
    'display_foresite_link_meta_box',
    'foresite_link', 'normal', 'high'
  );
}


function display_foresite_link_meta_box( $foresite_link ) {
  $foresite_link_url = esc_html( get_post_meta( $foresite_link->ID, 'foresite_link_url', true ) );
  ?>
  <input type="text" name="foresite_link_url" value="<?php echo $foresite_link_url; ?>" style="width: 100%;">
  <?php
}


add_action( 'save_post', 'add_foresite_link_fields', 10, 2 );
function add_foresite_link_fields( $foresite_link_id, $foresite_link ) {
  if ( $foresite_link->post_type == 'foresite_link' ) {
    if ( isset( $_POST['foresite_link_url'] ) && $_POST['foresite_link_url'] != '' ) {
      update_post_meta( $foresite_link_id, 'foresite_link_url', $_POST['foresite_link_url'] );
    }
  }
}


add_shortcode('foresite-links','get_foresite_links');
function get_foresite_links($atts, $content = null) {
  extract(shortcode_atts(array("number" => '20', "wrap" => 'yes'), $atts));

  ob_start();

  $args = array ( 
    'post_type'      => 'foresite_link',
    'orderby'        => 'date',
    'order'          => 'DESC',
    'posts_per_page' => $number
  );

  $query = new WP_Query($args);

  if ($query->have_posts()) :
    while ($query->have_posts() ) : $query->the_post();
      if ($wrap == "yes") echo "<div class=\"foresite-link\">";
      ?>
      <a href="<?php echo esc_html(get_post_meta(get_the_ID(), 'foresite_link_url', true)); ?>"><?php the_title(); ?></a>
      <?php
      if ($wrap == "yes") echo "</div>";
    endwhile;
  endif;

  wp_reset_query();

  return ob_get_clean();
}



add_action('admin_menu', 'foresite_links_register_instructions');
function foresite_links_register_instructions() {
  add_submenu_page( 'edit.php?post_type=foresite_link', __('How It Works', 'foresite-links'), __('How It Works', 'foresite-links'), 'read', 'foresite-links-instructions', 'foresite_links_instructions' );
}

function foresite_links_instructions() { ?>
  <div id="post-body-content" style="width: 98%;">
    <div class="metabox-holder">
      <div class="meta-box-sortables ui-sortable">
        <div class="postbox">
          
          <h3 class="hndle" style="font-size: 18px;">
            <span>How It Works</span>
          </h3>
          
          <div class="inside" style="font-size: 16px;">
            You can insert the links into any page by pasting in the shortcode <code>[foresite-links]</code>. By default, this will display a list of the 20 most recent links, sorted by date newest to oldest. They will also be wrapped in a <code>&lt;div&gt;</code> tag with a class of <code>foresite-link</code> for styling purposes.<br>
            <br>

            These settings can be changed by adding modifiers to the shortcode. To change the number links displayed (to 30 for example), add <code>number="30"</code> so the shortcode looks like this: <code>[foresite-links number="30"]</code>.<br>
            <br>

            If you would like to remove the wrapping div from the links, add <code>wrap="no"</code> so the shortcode looks like this: <code>[foresite-links wrap="no"]</code>.<br>
            <br>

            You may add multiple modifiers to the shortcode. For example, <code>[foresite-links number="30" wrap="no"]</code>.<br>
            <br>

            You may also display the links directly into a template using <code>&lt;?php echo do_shortcode('[foresite-links]'); ?&gt;</code>
          </div>
        </div>
      </div>
    </div>
  </div>
<?php
}
?>