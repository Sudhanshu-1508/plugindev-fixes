<?php
function myplugin_tst_shortcode(  ){
    return "short";
}
add_shortcode('my-test-code' , 'myplugin_tst_shortcode');