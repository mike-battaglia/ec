// Check if user role is 'certified_buyer'
function is_certified_buyer($user_id) {
    $user = get_userdata($user_id);
    return in_array('certified_buyer', $user->roles);
}

// Apply 15% discount on product's regular price
function apply_certified_buyer_discount($price) {
    $discount_rate = 0.15;
    return round($price - ($price * $discount_rate), 2);
}

// Display new price with discount for 'certified_buyer' role
function display_price_with_discount( $price, $product ) {
    if ( is_user_logged_in() && is_certified_buyer( get_current_user_id() ) ) {

        if ( $product->is_type( 'variable' ) ) {
            $variation_min_price = apply_certified_buyer_discount( $product->get_variation_price( 'min' ) );
            $variation_max_price = apply_certified_buyer_discount( $product->get_variation_price( 'max' ) );

            if ( $variation_min_price !== $variation_max_price ) {
                $price = wc_format_price_range( $variation_min_price, $variation_max_price );
            } else {
                $price = wc_price( $variation_min_price );
            }
        } else {
            $regular_price = floatval( $product->get_regular_price() );
            $discount_price = apply_certified_buyer_discount( $regular_price );

            if ( $discount_price !== $regular_price ) {
                $price = '<del>' . wc_price( $regular_price ) . '</del><br><ins><span class="certified-price-ins">Designer net: ' . wc_price( $discount_price ) . '</span></ins>';
            }
        }
    }

    return $price;
}

add_filter( 'woocommerce_get_price_html', 'display_price_with_discount', 10, 2 );

// Adjust admin commission and vendor payout based on the discount
function adjust_certified_buyer_commission( $commission, $order, $vendor_id, $product_id ) {
    $user_id = get_current_user_id();
    $product = wc_get_product( $product_id );

    if ( is_user_logged_in() && is_certified_buyer( $user_id ) ) {
        if ( $product->is_type( 'variable' ) ) {
            $variation = new WC_Product_Variation( $product_id );
            $regular_price = floatval( $variation->get_regular_price() );
        } else {
            $regular_price = floatval( $product->get_regular_price() );
        }

        $discount_price = apply_certified_buyer_discount( $regular_price );

        if ( $discount_price !== $regular_price ) {
            // Adjust admin's commission
            $adjusted_commission = $commission - ( $regular_price - $discount_price );

            // Ensuring commission does not become less than zero
            if( $adjusted_commission < 0 ) {
                $adjusted_commission = 0;
            }

            return $adjusted_commission;
        }
    }

    return $commission;
}

add_filter( 'dokan_order_item_total_commission', 'adjust_certified_buyer_commission', 10, 4 );

// Modify cart item price for certified buyer roles
function apply_certified_buyer_discount_to_cart_items($cart) {
    if (is_admin() && !defined('DOING_AJAX')) {
        return;
    }

    if (is_user_logged_in() && is_certified_buyer(get_current_user_id())) {
        foreach ($cart->get_cart() as $cart_item_key => $cart_item) {
            $product = $cart_item['data'];
            $price = $product->get_regular_price();
            $discounted_price = apply_certified_buyer_discount($price);

            if ($product->is_type('variable')) {
                $variation = new WC_Product_Variation($product->get_id());
                $price = $variation->get_regular_price();
                $discounted_price = apply_certified_buyer_discount($price);
            }

            if ($discounted_price !== $price) {
                $cart_item['data']->set_price($discounted_price);
            }
        }
    }
}

add_action('woocommerce_before_calculate_totals', 'apply_certified_buyer_discount_to_cart_items', 10, 1);

// Display original price and discounted price in cart table
function display_discounted_price_in_cart($price, $values, $cart_item_key )
{
    $product = $values['data'];

    if (is_user_logged_in() && is_certified_buyer(get_current_user_id())) {
        $regular_price = floatval($product->get_regular_price());
        $discount_price = apply_certified_buyer_discount($regular_price);
        $price = wc_price($regular_price)/* . '<br><del>' . wc_price($discount_price) . '</del>'*/;
    }

    return $price;
}

add_filter('woocommerce_cart_item_price', 'display_discounted_price_in_cart', 10, 3);

// Modify cart subtotal title
function modify_cart_subtotal_title($translated_text, $text, $domain) {
    if ('woocommerce' === $domain && 'Subtotal' === $text && is_cart() && is_user_logged_in() && is_certified_buyer(get_current_user_id())) {
        $translated_text = __('Designer Net Subtotal', 'woocommerce');
    }

    return $translated_text;
}

add_filter('gettext', 'modify_cart_subtotal_title', 10, 3);

// Display original price and discounted price on checkout and order details pages
function display_discounted_price_in_order_details($product_name, $item) {
    if ($item instanceof WC_Order_Item_Product) {
        $product = $item->get_product();

        if ($product && is_user_logged_in() && is_certified_buyer(get_current_user_id())) {
            $regular_price = floatval($product->get_regular_price());
            $discount_price = apply_certified_buyer_discount($regular_price);
            $product_name .= '<br>Retail: ' . wc_price($regular_price) . '<br>Designer Net: ' . wc_price($discount_price);
        }
    }

    return $product_name;
}

add_filter('woocommerce_order_item_name', 'display_discounted_price_in_order_details', 10, 2);
add_filter('woocommerce_checkout_cart_item_quantity', 'display_discounted_price_in_order_details', 10, 2);
