<?php
//add content

 

function add_content_on_activation() {
    if( get_option( 'my_page_id', false )){
        return;
    }
    $post_id = wp_insert_post(array(
        'post_title'=>__('Hello World confirmation', 'myplugin-sk' ),
        'post_status'=>'publish',
        'post_type' => 'page',
        'post_content' => '[my-test-code]',
    ));
    update_option( 'my_page_id', $post_id );
}

register_activation_hook( MYPLUGIN_FILE, 'add_content_on_activation');


function repalce_content_on_confirmed_page ( $content ) {
    if( get_the_ID() === intval(get_option( 'my_page_id', false ) )){
    return '[my-test-code]';
    }
    return $content;
}
add_filter(MYPLUGIN_FILE , 'repalce_content_on_confirmed_page' );

