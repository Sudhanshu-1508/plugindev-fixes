<?php

/**
 * 
 * 
 * Plugin Name: myplugin
 * Author: Sudhanshu
 * Version: 1.0
 * 
 */

 function my_plugin_load_textdomain() {
    load_plugin_textdomain( 'myplugin-sk', false, dirname( plugin_basename( __FILE__ ) ) . '/languages/' );
}
  add_action( 'plugins_loaded', 'my_plugin_load_textdomain' );
  
if( !defined("ABSPATH"))
    die('No script');

define( 'MYPLUGIN_FILE' , __FILE__ );
define('THEME_VERSION', '1.0');

require_once dirname(__FILE__) . '/includes/wp_requirements.php';
$plugin_checks = new Plugin_Requirements( 'myplugin', MYPLUGIN_FILE, array(
    'PHP' => '5.3.3'  ,
  'WordPress' => '4.1'
) );
if( false === $plugin_checks->pass() ){
    $plugin_checks_->halt();
    return;
}

require_once dirname(__FILE__) . '/includes/short_code.php';
require_once dirname(__FILE__) . '/includes/custom_post_type.php';
require_once dirname(__FILE__) . '/includes/admin_settings.php';
require_once dirname(__FILE__) . '/includes/news_content.php';
require_once dirname(__FILE__) . '/includes/add_content.php';
//require_once dirname(__FILE__) . '/includes/test_api_calls.php';
require_once dirname(__FILE__) . '/includes/welcome_screen.php';
require_once dirname(__FILE__) . '/includes/news_meta_box.php';
require_once dirname(__FILE__) . '/includes/news_location.php';


if ( have_posts() ) {
    while ( have_posts() ) {
      the_post();
      the_content();
    }
  }
  
  
  $post_id = get_the_ID();
  $content = get_post_field('post_content', $post_id);
  echo $content;
  
function add_news_location_to_content( $content ){
    if( is_singular( 'news' ) && get_option('show_related' , true) ){
        $location = get_news_location(get_the_ID( ) );
        $content = '<p class="news-lat-lon">' .  esc_html( $location->lat ) . ', ' . esc_html($location->lon) . '</p>' . $content;
        $content .= '<p class="news-location">' . esc_html(get_post_meta(get_the_ID(), '_news_location', true)) . '</p>' ;
       
    }
        return $content;
}
add_filter( 'the_content' , 'add_news_location_to_content' );



function add_post_to_end_of_content( $content ){
    global $post;
    if( is_singular( 'news' ) ){
        $args = array(
            'numberposts' => intval( get_option( 'related_news_amount',3)),
            'post_type'=>'news',
            'post__not_in'=>array( get_the_ID( ) ),
            'meta_key' => '_news_location',
            'meta_value'=> get_post_meta( get_the_ID(), '_news_location', true)
        );
        $wp_query = new WP_Query ( $args );
        if( $wp_query->have_posts( ) ){
            ob_start();
            ?>
            <h3><?php echo esc_html(get_option( 'custom_news_related_title' , 'Related News' ))?></h3>
            <ul class="latest-posts">
                <?php while ($wp_query->have_posts() ) : $wp_query->the_post() ; ?>
                    <li><a href="<?php echo get_the_permalink( $wp_query->post->ID );?>"><?php echo the_title(); ?></a></li>
                <?php endwhile; ?>
            </ul>
            <?php 
            $content .= ob_get_clean();
            wp_reset_postdata();
        }
    }
    return $content;
}
add_filter( 'the_content', 'add_post_to_end_of_content');

