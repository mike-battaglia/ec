<?php
/**
 * Loop Add to Cart
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/loop/add-to-cart.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see         https://docs.woocommerce.com/document/template-structure/
 * @package     WooCommerce\Templates
 * @version     3.3.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

global $product;

/* STATUS: INCOMPLETE
 * [X] Display Vendor Name
 * [ ] Display Vendor State (long, like California)
 * [ ] Display n"H X n"W X n"D
 * [ ] Display Wishlist Button
 * [x] Display Cart Button
 */
echo '<div class="custom-details">';
echo '<p class="vendor-name">';
echo get_the_author();
echo '</a></p>';

echo '<p class="vendor-state">';
$mbatt_vendor_id = get_the_author_meta('ID');
$mbatt_vendor = dokan_get_store_info($mbatt_vendor_id);
$mbatt_vendorstate = convertState($mbatt_vendor['address']['state']);
echo $mbatt_vendorstate;
echo '</p>';

//echo '<p class="product-dimensions">Product Dimensions Go Here</p>';
/*Dimentions Code*/
    $acf_width = get_field("acf_width");
    $acf_height = get_field("acf_height");
    $acf_length = get_field("acf_length");
    $before = "";
    $output = "";
    $count = 0;
    if($acf_height){
        $output .= $acf_height . '"H';
         $count++;
    }
    if($acf_width){
        if($count>0){
            $output .= " X ";
        }
        $output .= $acf_width . '"W';
        $count++;
    }
    if($acf_length){
        if($count>0){
            $output .= " X ";
        }
        $output .= $acf_length . '"D';
    }
    if($output !== ""){
        $before = '<p class="product-dimensions">' . $output . '</p>';
    }
    echo $before;
/*Dimentions Code*/

echo '</div>';

echo '<div class="heart-and-cart">';

/*Whishlist code start*/
$class_name = woocommerce_wishlists_get_wishlists_for_product( $product->get_id() ) ? 'wl-button-already-in' : '';
?>
<div id="wl-wrapper" class="woocommerce wl-button-wrap wl-row wl-clear <?php echo $class_name; ?>">
<a href="#" class="wl-add-to wl-add-to-loop  wl-add-link star wishlist_updator" data-prod_id="<?php echo $product->get_id() ?>"></a>
</div>
<?php
/*Whishlist code End*/

echo apply_filters(
	'woocommerce_loop_add_to_cart_link', // WPCS: XSS ok.
	sprintf(
		'<div class="add-to-cart-wrangler"><a href="%s" data-quantity="%s" style="background-color: transparent; color: #64656b;" class="%s" %s><i class="fa fa-shopping-cart fa-add-to-cart"></i></a></div>',
		esc_url( $product->add_to_cart_url() ),
		esc_attr( isset( $args['quantity'] ) ? $args['quantity'] : 1 ),
		esc_attr( isset( $args['class'] ) ? $args['class'] : 'button' ),
		isset( $args['attributes'] ) ? wc_implode_html_attributes( $args['attributes'] ) : '',
		esc_html( $product->add_to_cart_text() )
	),
	$product,
	$args
);
//echo do_shortcode( '[yith_wcwl_add_to_wishlist]' );
echo '</div>';

$exits_lists = array();
$disabled = 'style="pointer-events: none;color:#666;"';
$exists = '<span> (Added)</span>';
if($product):
    if ( woocommerce_wishlists_get_wishlists_for_product( $product->get_id() ) ) :
        foreach ( woocommerce_wishlists_get_wishlists_for_product( $product->get_id() ) as $list_id ) : 
            $exits_lists[] = $list_id;
        endforeach; 
    endif;
endif;
echo '<div id="wishlist-content-' . $product->get_id() . '" style="display:none;">';?>
<!--<a class="wl-pop-head">Add to Wishlist</a>-->
    <form action="<?php echo esc_url( add_query_arg( array( 'add-to-wishlist-itemid' => $product->get_id() ) ) ); ?>" method="post" id="wishlist-form-<?php echo $product->get_id(); ?>" class="">
        <input type="hidden" name="wlid" id="wlid"/>
        <input type="hidden" name="add-to-wishlist-type" value="<?php echo $product->get_type(); ?>"/>
        <input type="hidden" name="wl_from_single_product" value="1"/>    
    </form>
        <?php if(WC_Wishlists_User::get_wishlists()): ?>
        <dl>
            <?php $lists = WC_Wishlists_User::get_wishlists( 'Public' ); ?>
            <?php if ( $lists && count( $lists ) ) : ?>
                <dt><?php _e( 'Your Public Lists', 'wc_wishlist' ); ?></dt>
                <?php foreach ( $lists as $list ) : ?>
                    <dd>
                        <a rel="nofollow" class="wl-add-to-single" href="#" data-listid="<?php echo $list->id; ?>" <?php echo (in_array($list->id, $exits_lists))? $disabled:'' ?>><?php $list->the_title(); ?><?php echo (in_array($list->id, $exits_lists))? $exists:'' ?></a>
                    </dd>
                <?php endforeach; ?>
            <?php endif; ?>

            <?php $lists = WC_Wishlists_User::get_wishlists( 'Shared' ); ?>
            <?php if ( $lists && count( $lists ) ) : ?>
                <dt><?php _e( 'Your Shared Lists', 'wc_wishlist' ); ?></dt>
                <?php foreach ( $lists as $list ) : ?>
                    <dd>
                        <a rel="nofollow" class="wl-add-to-single" href="#" data-listid="<?php echo $list->id; ?>" <?php echo (in_array($list->id, $exits_lists))? $disabled:'' ?>><?php $list->the_title(); ?><?php echo (in_array($list->id, $exits_lists))? $exists:'' ?></a>
                    </dd>
                <?php endforeach; ?>
            <?php endif; ?>

            <?php $lists = WC_Wishlists_User::get_wishlists( 'Private' ); ?>
            <?php if ( $lists && count( $lists ) ) : ?>
                <dt><?php _e( 'Your Private Lists', 'wc_wishlist' ); ?></dt>
                <?php foreach ( $lists as $list ) : ?>
                    <dd>
                        <a class="wl-add-to-single" href="#" data-listid="<?php echo $list->id; ?>" <?php echo (in_array($list->id, $exits_lists))? $disabled:'' ?>><?php $list->the_title(); ?><?php echo (in_array($list->id, $exits_lists))? $exists:'' ?></a>
                    </dd>
                <?php endforeach; ?>
            <?php endif; ?>
        </dl>
    <?php endif; ?>
    <?php $max_list_count = apply_filters( 'wc_wishlists_max_user_list_count', '*' ); ?>
    <?php if ( $max_list_count === '*' || ( empty( $all_users_list ) || count( $all_users_list ) < $max_list_count ) ): ?>
        <strong><a rel="nofollow" class="wl-add-to-single button" data-listid="session" href="#"><?php _e( 'Create a new list', 'wc_wishlist' ); ?></a></strong>
    <?php endif; ?>


<?php    
echo '</div>';