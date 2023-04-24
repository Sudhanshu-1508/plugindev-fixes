<?php
function myplugin_tst_shortcode( $atts, $content='' ){
    $atts = shortcode_atts( array(
        'color' => '#0a0a0a',
    ) , $atts); 
    ob_start();
    ?>
    <div class="test">
        <h2><?php echo $content; ?></h2>
        <span style="color:<?php echo $atts['color'] ?>">testing</span>
    </div>
    <?php
    return ob_get_clean();
}
add_shortcode('my-test-code' , 'myplugin_tst_shortcode');