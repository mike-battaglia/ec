
<?php 
global $product;
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

$all_users_list = WC_Wishlists_User::get_wishlists(); ?>

<div id="wl-list-pop-wrap" style="display:none;"></div><!-- /wl-list-pop-wrap -->
<div class="wl-list-pop woocommerce" style="display:none;">
    <!--<a class="wl-pop-head">Add to Wishlist</a>-->
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
	<?php $max_list_count = apply_filters( 'wc_wishlists_max_user_list_count', '*' ); ?>
	<?php if ( $max_list_count === '*' || ( empty( $all_users_list ) || count( $all_users_list ) < $max_list_count ) ): ?>
        <strong><a rel="nofollow" class="wl-add-to-single button" data-listid="session" href="#"><?php _e( 'Create a new list', 'wc_wishlist' ); ?></a></strong>
	<?php endif; ?>
</div>
