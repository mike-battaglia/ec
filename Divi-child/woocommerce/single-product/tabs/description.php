<?php
/**
 * Description tab
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/tabs/description.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 2.0.0
 */

defined( 'ABSPATH' ) || exit;

global $post;

$heading = apply_filters( 'woocommerce_product_description_heading', __( 'Artwork Story', 'woocommerce' ) );

?>

<?php if ( $heading ) : ?>
	<h2><?php echo esc_html( $heading ); ?></h2>
<?php endif; ?>

<?php the_content(); ?>

<div id="mbatt-product-meta">
<hr>
<h2>Specifications</h2>

<?php
function mbatt_get_terms($taxa) {
	$term_obj_list = get_the_terms( $post->ID, $taxa );
	if (!empty($term_obj_list)) {
		$terms_string = join(', ', wp_list_pluck($term_obj_list, 'name'));
		echo $terms_string;
    } else {
    	echo "not listed";
    }
};

?>
	<p><span class="meta-key">Dimensions (in): </span><span class="meta-value"><?php echo do_shortcode('[woo_custom_field id="acf_height"]'); ?>"H &times; <?php echo do_shortcode('[woo_custom_field id="acf_width"]'); ?>"W &times; <?php echo do_shortcode('[woo_custom_field id="acf_length"]'); ?>"D</span></p>
	<p><span class="meta-key">Weight (lbs): </span><span class="meta-value"><?php echo do_shortcode('[woo_custom_field id="_weight"]'); ?> lbs</span></p>
	<p><span class="meta-key">Category: </span><span class="meta-value"><?php mbatt_get_terms('product_cat');?></span></p>
	<p><span class="meta-key">Medium: </span><span class="meta-value"><?php mbatt_get_terms('medium');?></span></p>
	<p><span class="meta-key">Subject: </span><span class="meta-value"><?php mbatt_get_terms('subject');?></span></p>
	<p><span class="meta-key">Style: </span><span class="meta-value"><?php mbatt_get_terms('style');?></span></p>
	<p><span class="meta-key">Type: </span><span class="meta-value"><?php mbatt_get_terms('types');?></span></p>
	<!--<p><span class="meta-key">Color(s): </span><span class="meta-value"><?php mbatt_get_terms('color');?></span></p>-->
	<p><span class="meta-key">Ready to hang/install: </span><span class="meta-value"><?php echo do_shortcode('[woo_custom_field id="acf_ready_to_hang"]'); ?></span></p>
	<p><span class="meta-key">Signed: </span><span class="meta-value"><?php echo do_shortcode('[woo_custom_field id="acf_signed"]'); ?></span></p>
	<p><span class="meta-key">Customizable: </span><span class="meta-value"><?php echo do_shortcode('[woo_custom_field id="acf_customizable"]'); ?></span></p>
	<p><span class="meta-key">Special care isntructions: </span><span class="meta-value"><?php echo do_shortcode('[woo_custom_field id="_purchase_note"]'); ?></span></p>
</div>