<?PHP
function welcome_screen_page() {

        add_dashboard_page( 'Welcome', 'Welcome', 'read', 'custom-plugin-welcome', 'display_welcome_page' );
}
add_action( 'admin_menu','welcome_screen_page' );

function display_welcome_page() {
    include dirname(__FILE__) . '/templates/welcome_page.php';
}

function remove_welcome_page_menu_item(){
    remove_submenu_page( 'index.php', 'custom-plugin-welcome' );
}
add_action( 'admin_head',  'remove_welcome_page_menu_item' );

function welcome_screen_activate() {
    set_transient( 'welcome_screen_activation_redirect', true, 30 );
}
register_activation_hook( MYPLUGIN_FILE , 'welcome_screen_activate' );

function welcome_page_redirect(  ) {

    if( ! get_transient( 'welcome_screen_activation_redirect' )) {
        return;
    }

    delete_transient( 'welcome_screen_activation_redirect' );

    if( isset( $_GET['activate-multi'] ) ) {
        return;
    }

   
        wp_safe_redirect( admin_url( 'index.php?page=custom-plugin-welcome' ) );
        die();
    
}
add_action( 'admin_init', 'welcome_page_redirect');