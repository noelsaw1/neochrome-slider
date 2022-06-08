<?php
/*
Plugin Name: Neochrome Post Slider
Description: Custom Post Slider
Author: Neochrome
License: GPLv2
License URI: https://www.gnu.org/licenses/gpl-2.0.html
Version: 1.0
Author URI: http://neochro.me
*/


if (!function_exists('write_log')) {

	function write_log ( $log )  {
  /*
		if ( true === WP_DEBUG ) {
			if ( is_array( $log ) || is_object( $log ) ) {
				error_log( print_r( $log, true ) );
			} else {
				error_log( $log );
			}
		}
      //*/
	}

}
write_log('in '.__FILE__);
add_action('wp_enqueue_scripts', 'nps_setting_up_scripts');
function nps_setting_up_scripts() { 
	wp_register_style( 'neochrome-post-slider-styles', plugins_url( 'post-slider-styles.css', __FILE__ ), array(), '20211018d' );
	wp_enqueue_style( 'neochrome-post-slider-styles' );
  wp_register_style( 'nps-slick-slider-css', plugins_url( 'slick.css', __FILE__ ) );
	wp_enqueue_style( 'nps-slick-slider-css' );
  wp_register_style( 'nps-slick-slider-theme-css', plugins_url( 'slick-theme.css', __FILE__ ) );
	wp_enqueue_style( 'nps-slick-slider-theme-css' );
  wp_enqueue_script( 'slick-slider', plugins_url('slick.js', __FILE__ ) , array('jquery'), '20211018c', false );
  wp_enqueue_script( 'nps-slider', plugins_url('nps-slider.js', __FILE__ ) , array('slick-slider'), '20211018c', false );
}


add_action( 'init', 'neochrome_post_slider_setup' );


function header_add() {

  $args = array(
    'post_type' => 'post',
    'category_name' => 'neochrome-slider',
    'order' => 'asc'
  );
  $slider_query = new WP_Query( $args );

  if ( $slider_query->have_posts() ) {
    while ( $slider_query->have_posts() ) {
      $slider_query->the_post(); 
      $post_thumbnail_id = get_post_thumbnail_id();
      $slide_featured = wp_get_attachment_image_src($post_thumbnail_id, 'nps-slider-background');
      $slide_mobile_featured = wp_get_attachment_image_src($post_thumbnail_id, 'nps-slider-mobile-background');

      //<link rel="preload" as="image" imagesrcset="IMAGE 1170w, wolf_800px.jpg 800w, wolf_1600px.jpg 1600w" imagesizes="50vw">
      ?>
      <link rel="preload" as="image" imagesrcset="<?php echo $slide_featured['0'] ?> 1170w, <?php echo $slide_mobile_featured['0'] ?> 400w" imagesizes="100vw">
      <?php
    }
  }
  wp_reset_postdata();
/*
  ?>
      <style class="neochrome-post-slider">
html body #nps-slider-container,html body #nps-slider-container .nps-slide{display:block;position:relative;width:100%;height:400px;overflow:hidden}html body #nps-slider-container *,html body #nps-slider-container :after,html body #nps-slider-container :before{box-sizing:inherit}html body #nps-slider-container .nps-slide{background-position:center center;background-size:cover;min-height:400px}html body #nps-slider-container .nps-slide-layout-wrap{display:block;position:relative;width:100%;height:100%}html body #nps-slider-container .nps-slide-content-wrapper{display:block;position:relative;top:50%;-webkit-transform:translateY(-50%);transform:translateY(-50%);width:45%;padding:15px 30px;text-shadow:1px 1px 3px rgba(0,0,0,.4)}html body #nps-slider-container .nps-slide-content-wrapper.nps-content-left{margin-left:0;margin-right:auto;left:0}html body #nps-slider-container .nps-slide-content-wrapper.nps-content-left .nps-cta-button{margin-left:auto;margin-right:0;right:0}html body #nps-slider-container .nps-slide-content-wrapper.nps-content-right{margin-left:auto;margin-right:0;left:0}html body #nps-slider-container .nps-slide-content-wrapper.nps-content-right .nps-cta-button{margin-left:0;margin-right:auto;left:0}html body #nps-slider-container .nps-slide-content-wrapper.nps-content-center{margin-left:auto;margin-right:auto;text-align:center}html body #nps-slider-container .nps-slide-content-wrapper.nps-content-center .nps-cta-button{margin-left:auto;margin-right:auto}@media screen and (max-width:767px){html body #nps-slider-container .nps-slide-content-wrapper{display:block;position:relative;top:50%;-webkit-transform:translateY(-50%);transform:translateY(-50%);width:90%;padding:15px 0;text-shadow:1px 1px 3px rgba(0,0,0,.4)}html body #nps-slider-container .nps-slide-content-wrapper.nps-content-left,html body #nps-slider-container .nps-slide-content-wrapper.nps-content-right{margin-left:auto;margin-right:auto;text-align:center;left:auto}html body #nps-slider-container .nps-slide-content-wrapper.nps-content-left .nps-cta-button{margin-left:auto;margin-right:auto;right:auto}html body #nps-slider-container .nps-slide-content-wrapper.nps-content-right .nps-cta-button{margin-left:auto;margin-right:auto;left:auto}html body #nps-slider-container .nps-slide-content-wrapper.nps-content-center{margin-left:auto;margin-right:auto;text-align:center}html body #nps-slider-container .nps-slide-content-wrapper.nps-content-center .nps-cta-button{margin-left:auto;margin-right:auto}}html body #nps-slider-container .nps-slide-title{color:#fff!important;font-size:50px!important;line-height:60px!important}html body #nps-slider-container .nps-the-content{color:#fff!important;font-size:19px;line-height:19px;font-weight:700}html body #nps-slider-container a.nps-cta-button{display:block;position:relative;width:158px;background:#59b957;color:#fff;font-size:19px;line-height:19px;padding:16px 30px;font-weight:700;margin-top:20px}html body #nps-slider-container .slick-next img,html body #nps-slider-container .slick-prev img{box-shadow:3px 3px 15px -15px #000}
      </style>

  <?php
*/
// add loop the link-preload all slider images

}
add_action('wp_head', 'header_add');


function neochrome_post_slider_setup() {
  add_image_size( 'nps-slider-background', 1200, 0, false );
  add_image_size( 'nps-slider-mobile-background', 400, 0, false );
  

	function nps_post_slider($atts){
		write_log('nps doing plugin nps_render_slider()');

    $args = array(
      'post_type' => 'post',
      'category_name' => 'neochrome-slider',
      'order' => 'asc'
    );
    $slider_query = new WP_Query( $args );

    if ( $slider_query->have_posts() ) {

		ob_start();


              ?>

		<div data-nps="1.0b" id="nps-slider-container" class="nps-slider-container xslick-slider clearfix">
      <div class="slick-slider">
      <?php 
        while ( $slider_query->have_posts() ) {
          $slider_query->the_post();
          
          $post_thumbnail_id = get_post_thumbnail_id();

          $slide_featured = wp_get_attachment_image_src($post_thumbnail_id, 'nps-slider-background');
          $slide_mobile_featured = wp_get_attachment_image_src($post_thumbnail_id, 'nps-slider-mobile-background');

          $text_layout_options = '';
          $cta_link = '';
          if ( function_exists('get_field') ) {
            $mobile_title = get_field("mobile_title");
            $mobile_image = get_field("mobile_image");
            write_log($mobile_image);
            $text_layout_options = get_field("text_layout_options");
            write_log('$layout_option:');
            write_log($text_layout_options);
            $cta_link = get_field("cta_link");
            write_log('$cta_link:');
            write_log($cta_link);
            if($mobile_image){
              $slide_mobile_featured = wp_get_attachment_image_src($mobile_image, 'nps-slider-mobile-background');
            }
          }
    ?>

      <div class="nps-slide slide-image-id-<?php echo $post_thumbnail_id?>">
      <div class="nps-slide-layout-wrap">
        <div class="nps-slide-content-wrapper nps-content-<?php echo $text_layout_options; ?>">
       
          <div class="h1 nps-slide-title"><?php echo get_the_title(); ?></div>
          <div class="h1 nps-mobile-slide-title"><?php echo $mobile_title ? $mobile_title : get_the_title(); ?></div>
          <div class="nps-the-content">
            <?php echo get_the_content(); ?>
          </div>
          <a href="<?php echo $cta_link['url']; ?>" class="nps-cta-button">
          <?php echo $cta_link['title'] ? $cta_link['title'] : 'Shop Now' ?>
          </a>
        </div>
        <div class="featured-product-img">
          <?php echo get_the_post_thumbnail( get_the_ID(), 'full' ); ?>
        </div>
      </div>
    </div>
      <?php } ?>
        </div>
		</div>

		<?php
    }
    wp_reset_postdata();
		return ob_get_clean();

	}
	write_log('about to add nps shortcode');
	add_shortcode( 'neochrome_post_slider', 'nps_post_slider' );

}
/*
function neochrome_hello_bar(){
  ?>
  <div id="neochrome-hellobar">
    <div class="nhb-flex-row">
      <div class="nhb-flex-item">
        <div class="nhb-flex-column">
          <div class="nhb-flex-item">
            25%
          </div>
          <div class="nhb-flex-item">
            OFF
          </div>
        </div>
      </div>
      <div class="nhb-flex-item">
        <div class="nhb-flex-column">
          <div class="nhb-flex-item">
            BLACK FRIDAY SALE ENDS:
          </div>
          <div class="nhb-flex-item">
            Fast Free and Discreet Shipping.
          </div>
        </div>
      </div>
      <div class="nhb-flex-item">
        Nov 30th 7AM
      </div>
      <div class="nhb-flex-item">
        coupon code here
      </div>
      <div class="nhb-flex-item">
        shop now button
      </div>
    </div>
  </div>
<?php 
}
//*/


function neochrome_hello_bar(){
  ?>
  <div id="neochrome-hellobar">
    <div class="nhb-flex-row">
      <div class="nhb-flex-item">
       <a href="/shop">
         <img height="60" width="775" class="neochrome-cta-image nps-hidden-sm" src="/wp-content/uploads/2021/11/blackfriday-banner.jpg">
         <img height="91" width="539" class="neochrome-cta-image nps-hidden-md nps-hidden-lg" src="/wp-content/uploads/2021/11/blackfriday-banner-mobile.png">
       </a>
      </div>
    </div>
  </div>
<?php 
}

function nps_check_query_vars( $vars ) {
  //write_log('query_vars:');
  //write_log($vars);
	return $vars;
}
add_filter( 'query_vars', 'nps_check_query_vars' );







//add_action('wp_body_open', 'neochrome_hello_bar');
