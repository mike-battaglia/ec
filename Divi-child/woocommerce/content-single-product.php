<?php
/**
 * The template for displaying product content in the single-product.php template
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/content-single-product.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 3.6.0
 */

defined( 'ABSPATH' ) || exit;

global $product;

/**
 * Hook: woocommerce_before_single_product.
 *
 * @hooked woocommerce_output_all_notices - 10
 */
do_action( 'woocommerce_before_single_product' );

if ( post_password_required() ) {
	echo get_the_password_form(); // WPCS: XSS ok.
	return;
}
?>
<div id="product-<?php the_ID(); ?>" <?php wc_product_class( '', $product ); ?>>

	<?php
	/**
	 * Hook: woocommerce_before_single_product_summary.
	 *
	 * @hooked woocommerce_show_product_sale_flash - 10
	 * @hooked woocommerce_show_product_images - 20
	 */
	do_action( 'woocommerce_before_single_product_summary' );
	?>


	<div class="summary entry-summary">
		<?php
		/**
		 * Hook: woocommerce_single_product_summary.
		 *
		 * @hooked woocommerce_template_single_title - 5
		 * @hooked woocommerce_template_single_rating - 10
		 * @hooked woocommerce_template_single_price - 10
		 * @hooked woocommerce_template_single_excerpt - 20
		 * @hooked woocommerce_template_single_add_to_cart - 30
		 * @hooked woocommerce_template_single_meta - 40
		 * @hooked woocommerce_template_single_sharing - 50
		 * @hooked WC_Structured_Data::generate_product_data() - 60
		 */
		do_action( 'woocommerce_single_product_summary' );
		?>
		<div class="request_quote_sec">
			<a class="button ec_request_quote" href="<?php echo get_permalink(146); ?>" data-prodid="<?php echo get_the_id(); ?>">Request a Quote</a>
		</div>
		<div class="certified-wrap">
			
				<p>Certified Trade Buyers only. To register, <a href="<?php echo get_permalink(437); ?>">click here.</a></p>
			
			<div class="ec-info">
				<div class="elementor-text-editor elementor-clearfix">
					<h3>
						<strong>EC Services;</strong>
					</h3>
					<ul>
						<li>Questions about this piece?</li>
						<li>Interested this artist’s work or other pieces in our showroom? <strong>We will happily find artwork for you.</strong></li>
						<li>Looking for a special commissioned piece? EC can help!</li>
					</ul>
					<p>
						<span class="contact-mail">
							<?php $email = 'sales@embracecreatives.com'; ?>
							<a href="mailto:<?php echo $email ?>">
								<img class="alignnone wp-image-33038" src="<?php echo site_url(); ?>/wp-content/uploads/2022/09/email-icon.png" alt="" width="30" height="21">
							</a>
		
								<a href="mailto:<?php echo $email ?>"> Contact an EC Art Advisor</a>
							
						</span>
					</p>
				</div>
			</div>
			
		</div>
	
</div>
	<div class="content-after-summary">
		<div class="artwork-title-tags">
			<div class="artwork-title">
				<h2><?php the_title(); ?></h2>
			</div>
			<div class="artwork-tags">
				<h4>Artwork Tags:</h4>
				<?php echo wc_get_product_tag_list( $product->get_id(), ', ', '<span class="tagged_as">' . _n( '', '', count( $product->get_tag_ids() ), 'woocommerce' ) . ' ', '</span>' ); ?>
			</div>
		</div>
	</div>

	<?php
	/**
	 * Hook: woocommerce_after_single_product_summary.
	 *
	 * @hooked woocommerce_output_product_data_tabs - 10
	 * @hooked woocommerce_upsell_display - 15
	 * @hooked woocommerce_output_related_products - 20
	 */
	do_action( 'woocommerce_after_single_product_summary' );
	?>
</div>

<?php do_action( 'woocommerce_after_single_product' ); ?>
