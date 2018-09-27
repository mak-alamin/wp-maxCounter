<?php
/**
 * @package maxCounter
 * @version 1.0
 */
/*
Plugin Name:maxCounter
Plugin URI: http://wordpress.org/plugins/maxCounter/
Description: This is the most simple , super lightwight counter plugin built with jquery. You can use it anywhere in your site.
Author: Mak Alamin
Version: 1.0
Author URI: http://maxsop.com
*/

if (!defined("ABSPATH")) { exit; }

//Counter Post Type
function counterPostType(){

  register_taxonomy(
        'counter-category',
        'max_counter',
        array(
            'label' => __( 'Categories' ),
            'rewrite' => array( 'slug' => 'counter-category' ),
            'hierarchical' => true
        )
    );

  $args = array(
          'labels' => array(
                        'name' => 'Max Counters' ,
                        'all_items' => 'All counters',
                        'add_new' => 'Add new counter' ,
                      ) ,
          'public' => true ,
          'menu_icon' =>  'dashicons-dashboard',
          'taxonomies' => array( 'counter' )
          );
  register_post_type( 'max_counter', $args );
}
add_action( 'init', 'counterPostType' );




//settings page
function max_counter_options_page() {
  add_options_page('maxCounter', 'Max Counter', 'manage_options', 'max_counter', 'max_counter_options_page_fn');
}
add_action('admin_menu', 'max_counter_options_page');
function max_counter_options_page_fn(){
  require_once (dirname(__FILE__).'/counter_settings.php');
}


// function max_counter_register_settings() {
//    add_option( 'max_counter_settings', 'Settings');
//    register_setting( 'maxplugin_options_group', 'max_counter_settings', 'max_counter_callback' );
// }
// add_action( 'admin_init', 'max_counter_register_settings' );
// function max_counter_callback(){
//
// }







//shortcode for the content
function ms_counter_content($atts, $content){
  extract(shortcode_atts( array(
    'num' =>  '8',
    'cat_id' => '',
    'bg_video'  => ''
  ), $atts));
  $counter_args = array(
                    'numberposts' => $num,
                    'post_type' => 'max_counter',
                    'category' => $cat_id
                  );
  $counter_posts = get_posts( $counter_args );
  // print_r($counter_posts);

ob_start();
?>
<section class="video-section">
    <video class="video" preload="auto" autoplay="true" loop="loop" muted="muted">
          <source src="<?php echo $bg_video; ?>" >
   </video>
    <div class="cover">
      <div class="numbers container">
        <div class="col-md-12">
          <div class="row">

            <!-- the loop -->
            <?php foreach ($counter_posts as $counter_post) { ?>
              <div class="col-lg-3 col-6 count-div">
                <div class="item">
                    <h3 class="counter"><?php echo $counter_post->post_content; ?></h3>
                    <h4><?php echo $counter_post->post_title; ?></h4>
                </div>
              </div>
            <?php } ?>
            <!-- the loope ends -->

          </div>
        </div>
      </div>
    </div>
</section>
<?php
  $counter = ob_get_clean();
  return $counter;
}
add_shortcode( 'max_counter', 'ms_counter_content' );
