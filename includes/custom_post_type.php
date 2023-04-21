<?php
/* Custom Post Type Start */
function create_posttype() {
    // Register News post type
    $args = array(
        'public'=> true,
        'label' => 'News',
        'has_archieve' =>true,
        'supports' => array('title', 'editor', 'excerpt', 'thumbnail')
    );

    register_post_type( 'news' , $args );
    
    // Register News Category taxonomy
    register_taxonomy(
        'news_category', 
        'news',  
        array(
           'hierarchal' => true,
           'label'=>'News Categories'
        )
    );
}
add_action( 'init', 'create_posttype' );

function posttype_activate(){
    create_posttype();
    flush_rewrite_rules();
}

register_activation_hook( MYPLUGIN_FILE , 'posttype_activate' );