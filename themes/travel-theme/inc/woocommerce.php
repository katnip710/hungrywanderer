<?php


/**
 * Change number of products that are displayed per page (shop page)
 */

function travel_theme_loop_shop_per_page($cols)
{
    // $cols contains the current number of products per page based on the value stored on Options -> Reading
    // Return the number of products you wanna show per page.
    $cols = 9;
    return $cols;
}

add_filter('loop_shop_per_page', 'travel_theme_loop_shop_per_page', 20);



/**
 * Change number or products per row to 3
 */

if (!function_exists('loop_columns')) {
    function loop_columns()
    {
        return 3; // 3 products per row
    }
}
add_filter('loop_shop_columns', 'loop_columns', 999);

// disable woocommerce default styling
add_filter('woocommerce_enqueue_styles', '__return_empty_array');


function travel_theme_woocommerce_login_form()
{
?>

    <p><strong>Don't forget your password!!!</strong></p>

<?php
}
add_action('woocommerce_login_form', 'travel_theme_woocommerce_login_form');


/**
 * Show cart contents / total Ajax
 */

function woocommerce_header_add_to_cart_fragment($fragments)
{
    global $woocommerce;

    ob_start();

?>
    <div class="mini-cart-wrapper">
        <?php woocommerce_mini_cart(); ?>
    </div>
<?php
    $fragments['.mini-cart-wrapper'] = ob_get_clean();
    return $fragments;
}

add_filter('woocommerce_add_to_cart_fragments', 'woocommerce_header_add_to_cart_fragment');