<?php

function get_news_location_table_name() {
    global $wpdb;
    return $table_name = $wpdb->prefix . 'news_location';
}

function create_news_location_table(){
    global $wpdb;

    $table_name = get_news_location_table_name();
    var_dump($table_name);
    $charset = $wpdb->get_charset_collate();

    $sql = "CREATE TABLE $table_name (
        post_id int(11) NOT NULL,
        lat decimal(9,6) NOT NULL,
        lon decimal(9,6) NOT NULL,
        PRIMARY KEY (post_id)
    ) $charset;";

    require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
    dbDelta( $sql );
}

register_activation_hook( __FILE__ , 'create_news_location_table' );

function get_news_location( $post_id ) {
    global $wpdb;

    $table_name = get_news_location_table_name();
    $news_location = get_transient( 'news_location' . $post_id );
    if($news_location){
        return $news_location;
    }
    $news_location = $wpdb->get_row( " SELECT * FROM $table_name WHERE post_id=" . intval($post_id));
    set_transient( 'news_location' .$post_id, $news_location );
    return $news_location;
}

function save_news_location( $post_id, $lat, $lon ){
    global $wpdb;
    if(get_news_location( $post_id ) ){
        $wpdb->update(
            get_news_location_table_name(),
            array(
                'lat' => $lat,
                'lon' => $lon 
            ),
            array( 'post_id' => $post_id),
            array(
                '%f',
                '%f' 
            ),
            array( '%d' )
        );
    } else {
        $wpdb->insert(
            get_news_location_table_name(),
            array(
                'post_id'=>$post_id,
                'lat'=> $lat,
                'lon'=>$lon
            ),
            array(
                '%d',
                '%f',
                '%f'
            )
        );
    }
    delete_transient( 'news_location' . $post_id );
}