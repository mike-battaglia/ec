<?php

//some custom js

use WeDevs\Dokan\Walkers\TaxonomyDropdown;

    $get_data  = wp_unslash( $_GET ); // WPCS: CSRF ok.
    $post_data = wp_unslash( $_POST ); // WPCS: CSRF ok.

    /**
     *  dokan_new_product_wrap_before hook
     *
     *  @since 2.4
     */
    do_action( 'dokan_new_product_wrap_before' );
?>

<?php do_action( 'dokan_dashboard_wrap_start' ); ?>

    <div class="dokan-dashboard-wrap">

        <?php

            /**
             *  dokan_dashboard_content_before hook
             *  dokan_before_new_product_content_area hook
             *
             *  @hooked get_dashboard_side_navigation
             *
             *  @since 2.4
             */
            do_action( 'dokan_dashboard_content_before' );
            do_action( 'dokan_before_new_product_content_area' );
        ?>


        <div class="dokan-dashboard-content">

            <?php

                /**
                 *  dokan_before_new_product_inside_content_area hook
                 *
                 *  @since 2.4
                 */
                do_action( 'dokan_before_new_product_inside_content_area' );
            ?>

            <header class="dokan-dashboard-header dokan-clearfix">
                <h1 class="entry-title">
                    Step 1 of 2: Create New Artwork
                </h1>
                    <p>Please enter basic information for the artwork below. On the following page, you will be prompted to add further details, like shipping, etc.</p>
            </header><!-- .entry-header -->


            <div class="dokan-new-product-area">
                <?php if ( dokan()->dashboard->templates->products->has_errors() ) { ?>
                    <div class="dokan-alert dokan-alert-danger">
                        <a class="dokan-close" data-dismiss="alert">&times;</a>

                        <?php foreach ( dokan()->dashboard->templates->products->get_errors() as $error) { ?>

                            <strong><?php esc_html_e( 'Error!', 'dokan-lite' ); ?></strong> <?php echo esc_html( $error ); ?>.<br>

                        <?php } ?>
                    </div>
                <?php } ?>

                <?php if ( isset( $get_data['created_product'] ) ): ?>
                    <div class="dokan-alert dokan-alert-success">
                        <a class="dokan-close" data-dismiss="alert">&times;</a>
                        <strong><?php esc_html_e( 'Success!', 'dokan-lite' ); ?></strong>
                        <?php printf( __( 'You have successfully created <a href="%s"><strong>%s</strong></a> product', 'dokan-lite' ), esc_url( dokan_edit_product_url( intval( $get_data['created_product'] ) ) ), get_the_title( intval( $get_data['created_product'] ) ) ); // phpcs:ignore WordPress.XSS.EscapeOutput.OutputNotEscaped ?>
                    </div>
                <?php endif ?>

                <?php

                $can_sell         = apply_filters( 'dokan_can_post', true );
                $can_create_tags  = dokan_get_option( 'product_vendors_can_create_tags', 'dokan_selling' );
                $tags_placeholder = 'on' === $can_create_tags ? __( 'Select tags/Add tags', 'dokan-lite' ) : __( 'Select product tags', 'dokan-lite' );

                if ( $can_sell ) {
                    $posted_img       = dokan_posted_input( 'feat_image_id' );
                    $posted_img_url   = $hide_instruction = '';
                    $hide_img_wrap    = 'dokan-hide';
                    $post_content     = isset( $post_data['post_content'] ) ? $post_data['post_content'] : '';

                    if ( !empty( $posted_img ) ) {
                        $posted_img     = empty( $posted_img ) ? 0 : $posted_img;
                        $posted_img_url = wp_get_attachment_url( $posted_img );
                        $hide_instruction = 'dokan-hide';
                        $hide_img_wrap = '';
                    }
                    if ( dokan_is_seller_enabled( get_current_user_id() ) ) { ?>

                        <form class="dokan-form-container" method="post">

                            <div class="product-edit-container dokan-clearfix">
                                <div class="content-half-part featured-image">
                                    <div class="featured-image">
                                        <div class="dokan-feat-image-upload">
                                            <div class="instruction-inside <?php echo esc_attr( $hide_instruction ); ?>">
                                                <input type="hidden" name="feat_image_id" class="dokan-feat-image-id" value="<?php echo esc_attr( $posted_img ); ?>">
                                                <i class="fa fa-cloud-upload"></i>
                                                <a href="#" class="dokan-feat-image-btn dokan-btn"><?php esc_html_e( 'Upload Product Image', 'dokan-lite' ); ?></a>
                                            </div>

                                            <div class="image-wrap <?php echo esc_attr( $hide_img_wrap ); ?>">
                                                <a class="close dokan-remove-feat-image">&times;</a>
                                                    <img src="<?php echo esc_url( $posted_img_url ); ?>" alt="">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="dokan-product-gallery">
                                        <div class="dokan-side-body" id="dokan-product-images">
                                            <div id="product_images_container">
                                                <ul class="product_images dokan-clearfix">
                                                    <?php
                                                        if ( isset( $post_data['product_image_gallery'] ) ) { // WPCS: CSRF ok, input var ok.
                                                            $product_images = $post_data['product_image_gallery']; // WPCS: CSRF ok, input var ok.
                                                            $gallery        = explode( ',', $product_images );

                                                            if ( $gallery ) {
                                                                foreach ( $gallery as $image_id ) {
                                                                    if ( empty( $image_id ) ) {
                                                                        continue;
                                                                    }

                                                                    $attachment_image = wp_get_attachment_image_src( $image_id, 'thumbnail' );
                                                                    ?>
                                                                    <li class="image" data-attachment_id="<?php echo esc_attr( $image_id ); ?>">
                                                                        <img src="<?php echo esc_url( $attachment_image[0] ); ?>" alt="">
                                                                        <a href="#" class="action-delete" title="<?php esc_attr_e( 'Delete image', 'dokan-lite' ); ?>">&times;</a>
                                                                    </li>
                                                                    <?php
                                                                }
                                                            }
                                                        }
                                                        ?>
                                                    <li class="add-image add-product-images tips" data-title="<?php esc_attr_e( 'Add gallery image', 'dokan-lite' ); ?>">
                                                        <a href="#" class="add-product-images"><i class="fa fa-plus" aria-hidden="true"></i></a>
                                                    </li>
                                                </ul>
                                                <input type="hidden" id="product_image_gallery" name="product_image_gallery" value="">
                                            </div>
                                        </div>
                                    </div> <!-- .product-gallery -->
                                    <?php do_action( 'dokan_product_gallery_image_count' ); ?>
                                </div>

                                <div class="content-half-part dokan-product-meta">
                                    <div class="dokan-form-group">
                                        <input class="dokan-form-control" name="post_title" id="post-title" type="text" placeholder="<?php esc_attr_e( 'Artwork Title...', 'dokan-lite' ); ?>" value="<?php echo esc_attr( dokan_posted_input( 'post_title' ) ); ?>">
                                    </div>

                                    <div class="dokan-form-group">
                                        <div class="dokan-form-group dokan-clearfix dokan-price-container">
                                            <div class="content-half-part">
                                                <label for="_regular_price" class="dokan-form-label"><?php esc_html_e( 'Price', 'dokan-lite' ); ?></label>
                                                <div class="dokan-input-group">
                                                    <span class="dokan-input-group-addon"><?php echo esc_attr__( get_woocommerce_currency_symbol() ); ?></span>
                                                    <input type="text" class="dokan-form-control wc_input_price dokan-product-regular-price" name="_regular_price" placeholder="0.00" id="_regular_price" value="<?php echo esc_attr( dokan_posted_input( '_regular_price' ) ) ?>">
                                                </div>
                                            </div>

                                            <!-- <div class="content-half-part sale-price">
                                                <label for="_sale_price" class="form-label">
                                                    <?php esc_html_e( 'Discounted Price', 'dokan-lite' ); ?>
                                                    <a href="#" class="sale_schedule"><?php esc_html_e( 'Schedule', 'dokan-lite' ); ?></a>
                                                    <a href="#" class="cancel_sale_schedule dokan-hide"><?php esc_html_e( 'Cancel', 'dokan-lite' ); ?></a>
                                                </label>

                                                <div class="dokan-input-group">
                                                    <span class="dokan-input-group-addon"><?php echo esc_attr__( get_woocommerce_currency_symbol() ); ?></span>
                                                    <input type="text" class="dokan-form-control wc_input_price dokan-product-sales-price" name="_sale_price" placeholder="0.00" id="_sale_price" value="<?php echo esc_attr( dokan_posted_input( '_sale_price' ) ) ?>">
                                                </div>
                                            </div> -->
                                        </div>

                                        <div class="dokan-hide sale-schedule-container sale_price_dates_fields dokan-clearfix dokan-form-group">
                                            <div class="content-half-part from">
                                                <div class="dokan-input-group">
                                                    <span class="dokan-input-group-addon"><?php esc_html_e( 'From', 'dokan-lite' ); ?></span>
                                                    <input type="text" name="_sale_price_dates_from" class="dokan-form-control datepicker sale_price_dates_from" maxlength="10" value="<?php echo esc_attr( dokan_posted_input('_sale_price_dates_from') ); ?>" pattern="[0-9]{4}-(0[1-9]|1[012])-(0[1-9]|1[0-9]|2[0-9]|3[01])" placeholder="<?php esc_attr_e( 'YYYY-MM-DD', 'dokan-lite' ); ?>">
                                                </div>
                                            </div>

                                            <div class="content-half-part to">
                                                <div class="dokan-input-group">
                                                    <span class="dokan-input-group-addon"><?php esc_html_e( 'To', 'dokan-lite' ); ?></span>
                                                    <input type="text" name="_sale_price_dates_to" class="dokan-form-control datepicker sale_price_dates_to" value="<?php echo esc_attr( dokan_posted_input('_sale_price_dates_to') ); ?>" maxlength="10" pattern="[0-9]{4}-(0[1-9]|1[012])-(0[1-9]|1[0-9]|2[0-9]|3[01])" placeholder="<?php esc_attr_e( 'YYYY-MM-DD', 'dokan-lite' ); ?>">
                                                </div>
                                            </div>
                                        </div><!-- .sale-schedule-container -->
                                    </div>

                                    <!-- <div class="dokan-form-group">
                                        <textarea name="post_excerpt" id="post-excerpt" rows="5" class="dokan-form-control" placeholder="<?php esc_attr_e( 'Short description of the product...', 'dokan-lite' ); ?>"><?php echo esc_attr( dokan_posted_textarea( 'post_excerpt' ) ); ?></textarea>
                                    </div> -->

                                    <?php /*if ( dokan_get_option( 'product_category_style', 'dokan_selling', 'single' ) == 'single' ): ?>
                                        <div class="dokan-form-group-cats">
                                        
                                            <?php
                                            $selected_cat  = dokan_posted_input( 'product_cat' );
                                            $category_args =  array(
                                                'show_option_none' => __( '- Select Main Artwork Category -', 'dokan-lite' ),
                                                'hierarchical'     => 1,
                                                'hide_empty'       => 0,
                                                'name'             => 'product_cat',
                                                'id'               => 'product_cat',
                                                'taxonomy'         => 'product_cat',
                                                'orderby'          => 'name',
                                                'title_li'         => '',
                                                'class'            => 'product_cat dokan-form-control dokan-select2',
                                                'exclude'          => '',
                                                'selected'         => $selected_cat,
                                                'walker'           => new TaxonomyDropdown()
                                            );

                                            wp_dropdown_categories( apply_filters( 'dokan_product_cat_dropdown_args', $category_args ) );
                                            ?>
                                        </div>
                                    <?php elseif ( dokan_get_option( 'product_category_style', 'dokan_selling', 'single' ) == 'multiple' ): ?>
                                        <div class="dokan-form-group">
                                            <?php

                                            include_once DOKAN_LIB_DIR.'/class.taxonomy-walker.php';

                                            $selected_cat  = dokan_posted_input( 'product_cat', true );
                                            $selected_cat  = empty( $selected_cat ) ? array() : $selected_cat;

                                            $drop_down_category = wp_dropdown_categories( apply_filters( 'dokan_product_cat_dropdown_args', array(
                                                'show_option_none' => __( '', 'dokan-lite' ),
                                                'hierarchical'     => 1,
                                                'hide_empty'       => 0,
                                                'name'             => 'product_cat[]',
                                                'id'               => 'product_cat',
                                                'taxonomy'         => 'product_cat',
                                                'orderby'          => 'name',
                                                'title_li'         => '',
                                                'class'            => 'product_cat dokan-form-control dokan-select2',
                                                'exclude'          => '',
                                                'selected'         => $selected_cat,
                                                'echo'             => 0,
                                                'walker'           => new TaxonomyDropdown()
                                            ) ) );

                                            echo str_replace( '<select', '<select data-placeholder="'.esc_attr__( 'Select product category', 'dokan-lite' ).'" multiple="multiple" ', $drop_down_category ); // phpcs:ignore WordPress.XSS.EscapeOutput.OutputNotEscaped
                                            ?>
                                        </div>
                                    <?php endif;*/ ?>

                                    <div class="dokan-form-group-tags">
                                        <label for="product_tag" class="form-label"><?php esc_html_e( 'Tags', 'dokan-lite' ); ?></label>
                                        <select multiple="multiple" placeholder="<?php echo esc_attr( $tags_placeholder ); ?>" name="product_tag[]" id="product_tag_search" class="product_tag_search product_tags dokan-form-control dokan-select2" data-placeholder="<?php echo esc_attr( $tags_placeholder ); ?>"></select>
                                    </div>

                                    <?php do_action( 'dokan_new_product_after_product_tags' ); ?>
                                </div>
                            </div>                                                                  
                                                                             
                            <div class="mbatt-dokan-product-description">
                                <h2 for="post_content" class=""><i class="fa fa-edit" aria-hidden="true"></i> Description</h2>
                                <?php wp_editor( htmlspecialchars_decode( $post_content, ENT_QUOTES ), 'post_content', array('editor_height' => 50, 'quicktags' => false, 'media_buttons' => false, 'teeny' => true, 'editor_class' => 'post_content') ); ?>
                       	        <p style="padding-top:12px;">“Why did you create this?” “What inspired it?” Help EC promote this and connect with the right buyer by sharing the “WHY” behind this piece.</p>
                                <p><b>Example #1:</b> Iznik pottery production goes back to the fifteenth century and is named for the place where it began in Turkey. When the Ottoman Empire built the Topkapi Palace and needed wall tile decoration, the artists moved to Istanbul. This image is inspired by the fabulous encrusted ceramic tile covered walls, found both inside and outside many of the Topkapi Palace buildings.</p>
								<p><b>Example #2:</b> This slab table is a unique expression of the original material, sustainably sourced from old-growth forests in the Pacific Northwest then painstakingly worked by hand to bring out the character of its life cycle. Dominant design elements include charred and polished live edges, traditional handmade butterfly keys, unique solid brass chevron keys, and a patterned diagram of patchwork inlays. Each piece is handled with care and specifically laid out to draw attention to the beauty of the grain and the feel and movement of the patchwork.</p>
                                </div>

                            <?php do_action( 'dokan_new_product_form' ); ?>

                            <hr>

                            <div class="dokan-form-group dokan-right">
                                <?php wp_nonce_field( 'dokan_add_new_product', 'dokan_add_new_product_nonce' ); ?>
                                <?php
                                $display_create_and_add_new_button = true;
                                if ( function_exists( 'dokan_pro' ) && dokan_pro()->module->is_active( 'product_subscription' ) ) {
                                    if ( \DokanPro\Modules\Subscription\Helper::get_vendor_remaining_products( dokan_get_current_user_id() ) === 1 ) {
                                        $display_create_and_add_new_button = false;
                                    }
                                }
                                if ( $display_create_and_add_new_button ) :
                                ?>
                                <button type="submit" name="add_product" class="dokan-btn dokan-btn-default" value="create_and_add_new"><?php esc_attr_e( 'Create & Add New', 'dokan-lite' ); ?></button>
                                <?php endif; ?>
                                <button id="mb_dokan_submit" type="submit" name="add_product" class="dokan-btn dokan-btn-default dokan-btn-theme" value="create_new"><?php esc_attr_e( 'Go to step 2', 'dokan-lite' ); ?></button>
                            </div>

                        </form>

                    <?php } else { ?>

                        <?php dokan_seller_not_enabled_notice(); ?>

                    <?php } ?>

                <?php } else { ?>

                    <?php do_action( 'dokan_can_post_notice' ); ?>

                <?php } ?>
            </div>

            <?php

                /**
                 *  dokan_after_new_product_inside_content_area hook
                 *
                 *  @since 2.4
                 */
                do_action( 'dokan_after_new_product_inside_content_area' );
            ?>

        </div> <!-- #primary .content-area -->

        <?php

            /**
             *  dokan_dashboard_content_after hook
             *  dokan_after_new_product_content_area hook
             *
             *  @since 2.4
             */
            do_action( 'dokan_dashboard_content_after' );
            do_action( 'dokan_after_new_product_content_area' );
        ?>

    </div><!-- .dokan-dashboard-wrap -->

<?php do_action( 'dokan_dashboard_wrap_end' ); ?>

<?php

    /**
     *  dokan_new_product_wrap_after hook
     *
     *  @since 2.4
     */
    do_action( 'dokan_new_product_wrap_after' );
?>

<script src="https://dev.embracecreatives.com/wp-content/themes/generatepress_child/js/custom_dokan_script.js"></script>
<script>
	let acfIds = ["acf_signed", "acf_customizable", "acf_ready_to_hang", "acf_width", "acf_height", "acf_length"];
    for ( i = 0; i < acfIds.length; i++ ) {
    	console.log(`Calling: ${acfIds[i]}`)
    	let acfChosen = document.getElementById(`${acfIds[i]}`).parentNode.children[0];
    	console.log(`Called: ${acfChosen}`);
    };

</script>
