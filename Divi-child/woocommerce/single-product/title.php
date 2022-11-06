<?php
/**
 * Single Product title
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/title.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see        https://docs.woocommerce.com/document/template-structure/
 * @package    WooCommerce\Templates
 * @version    1.6.4
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}
global $product;
woocommerce_breadcrumb();

the_title( '<h1 class="product_title entry-title">', '</h1>' );

?>

<?php

$mbatt_author_slug = get_the_author_meta('_vendor_page_slug');

$mbatt_author_name = get_the_author();

?>
   	<span id="mbatt-wcp-artist-link">
       <p><?php printf( '<a href="/store/%s">%s</a>', $mbatt_author_slug, $mbatt_author_name ); ?></p>
    </span>
    <?php 
    echo wc_get_stock_html( $product );
     ?>