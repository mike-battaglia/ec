<?php
// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) exit;

// BEGIN ENQUEUE PARENT ACTION
// AUTO GENERATED - Do not modify or remove comment markers above or below:

if ( !function_exists( 'chld_thm_cfg_locale_css' ) ):
    function chld_thm_cfg_locale_css( $uri ){
        if ( empty( $uri ) && is_rtl() && file_exists( get_template_directory() . '/rtl.css' ) )
            $uri = get_template_directory_uri() . '/rtl.css';
        return $uri;
    }
endif;
add_filter( 'locale_stylesheet_uri', 'chld_thm_cfg_locale_css' );

// END ENQUEUE PARENT ACTION

//-----//
//CREATE CUSTOM LOGIN LINK IN NAVIGATION
//FOR LOGGED OUT USERS = 'LOG IN'
//FOR LOGGED IN USERS = 'MY ACCOUNT'
add_filter('wp_nav_menu_items', 'add_login_logout_link', 10, 2);
function add_login_logout_link($items, $args) {
ob_start();
divi_help_loginout('index.php');
$loginoutlink = ob_get_contents();
ob_end_clean();
$items .= '<li>'. $loginoutlink .'</li>';
return $items;
}

function divi_help_loginout( $redirect = '', $echo = true ) {
    if ( ! is_user_logged_in() ) {
        $link = '<a href="' . esc_url( '/my-account/' ) . '">' . __( 'Log in' ) . '</a>';
    } else {
        $link = '<a href="' . esc_url( '/my-account/' ) . '">' . __( 'My Account' ) . '</a>';
    }
    if ( $echo ) {
        /**
         * Filters the HTML output for the Log In/Log Out link.
         *
         * @since 1.5.0
         *
         * @param string $link The HTML link content.
         */
        echo apply_filters( 'loginout', $link );
    } else {
        /** This filter is documented in wp-includes/general-template.php */
        return apply_filters( 'loginout', $link );
    }
}
//END CUSTOM LOGIN LINK//
//--------//

/* -----------------------------------
 * CONVERT STATE NAMES!
 * Goes both ways. e.g.
 * $name = 'Orgegon' -> returns "OR"
 * $name = 'OR' -> returns "Oregon"
 * ----------------------------------- */
function convertState($name) {
   $states = array(
      array('name'=>'Alabama', 'abbr'=>'AL'),
      array('name'=>'Alaska', 'abbr'=>'AK'),
      array('name'=>'Arizona', 'abbr'=>'AZ'),
      array('name'=>'Arkansas', 'abbr'=>'AR'),
      array('name'=>'California', 'abbr'=>'CA'),
      array('name'=>'Colorado', 'abbr'=>'CO'),
      array('name'=>'Connecticut', 'abbr'=>'CT'),
      array('name'=>'Delaware', 'abbr'=>'DE'),
      array('name'=>'Florida', 'abbr'=>'FL'),
      array('name'=>'Georgia', 'abbr'=>'GA'),
      array('name'=>'Hawaii', 'abbr'=>'HI'),
      array('name'=>'Idaho', 'abbr'=>'ID'),
      array('name'=>'Illinois', 'abbr'=>'IL'),
      array('name'=>'Indiana', 'abbr'=>'IN'),
      array('name'=>'Iowa', 'abbr'=>'IA'),
      array('name'=>'Kansas', 'abbr'=>'KS'),
      array('name'=>'Kentucky', 'abbr'=>'KY'),
      array('name'=>'Louisiana', 'abbr'=>'LA'),
      array('name'=>'Maine', 'abbr'=>'ME'),
      array('name'=>'Maryland', 'abbr'=>'MD'),
      array('name'=>'Massachusetts', 'abbr'=>'MA'),
      array('name'=>'Michigan', 'abbr'=>'MI'),
      array('name'=>'Minnesota', 'abbr'=>'MN'),
      array('name'=>'Mississippi', 'abbr'=>'MS'),
      array('name'=>'Missouri', 'abbr'=>'MO'),
      array('name'=>'Montana', 'abbr'=>'MT'),
      array('name'=>'Nebraska', 'abbr'=>'NE'),
      array('name'=>'Nevada', 'abbr'=>'NV'),
      array('name'=>'New Hampshire', 'abbr'=>'NH'),
      array('name'=>'New Jersey', 'abbr'=>'NJ'),
      array('name'=>'New Mexico', 'abbr'=>'NM'),
      array('name'=>'New York', 'abbr'=>'NY'),
      array('name'=>'North Carolina', 'abbr'=>'NC'),
      array('name'=>'North Dakota', 'abbr'=>'ND'),
      array('name'=>'Ohio', 'abbr'=>'OH'),
      array('name'=>'Oklahoma', 'abbr'=>'OK'),
      array('name'=>'Oregon', 'abbr'=>'OR'),
      array('name'=>'Pennsylvania', 'abbr'=>'PA'),
      array('name'=>'Rhode Island', 'abbr'=>'RI'),
      array('name'=>'South Carolina', 'abbr'=>'SC'),
      array('name'=>'South Dakota', 'abbr'=>'SD'),
      array('name'=>'Tennessee', 'abbr'=>'TN'),
      array('name'=>'Texas', 'abbr'=>'TX'),
      array('name'=>'Utah', 'abbr'=>'UT'),
      array('name'=>'Vermont', 'abbr'=>'VT'),
      array('name'=>'Virginia', 'abbr'=>'VA'),
      array('name'=>'Washington', 'abbr'=>'WA'),
      array('name'=>'West Virginia', 'abbr'=>'WV'),
      array('name'=>'Wisconsin', 'abbr'=>'WI'),
      array('name'=>'Wyoming', 'abbr'=>'WY'),
      array('name'=>'Virgin Islands', 'abbr'=>'V.I.'),
      array('name'=>'Guam', 'abbr'=>'GU'),
      array('name'=>'Puerto Rico', 'abbr'=>'PR'),
   	  array('name'=>'Armed Forces (Euro/MidEast)', 'abbr'=>'AE'),
	  array('name'=>'Armed Forces (Americas)', 'abbr' =>'AA'),
	  array('name'=>'Armed Forces (Pacific)', 'abbr'=>'AP')
   );

   $return = false;   
   $strlen = strlen($name);

   foreach ($states as $state) :
      if ($strlen < 2) {
         return false;
      } else if ($strlen == 2) {
         if (strtolower($state['abbr']) == strtolower($name)) {
            $return = $state['name'];
            break;
         }   
      } else {
         if (strtolower($state['name']) == strtolower($name)) {
            $return = strtoupper($state['abbr']);
            break;
         }         
      }
   endforeach;
   
   return $return;
} // end function convertState()

function slugifyState($short) {
   $states = array(
      array('slug'>'alabama', 'abbr'=>'AL'),
      array('slug'=>'alaska', 'abbr'=>'AK'),
      array('slug'=>'arizona', 'abbr'=>'AZ'),
      array('slug'=>'arkansas', 'abbr'=>'AR'),
      array('slug'=>'california', 'abbr'=>'CA'),
      array('slug'=>'colorado', 'abbr'=>'CO'),
      array('slug'=>'connecticut', 'abbr'=>'CT'),
      array('slug'=>'delaware', 'abbr'=>'DE'),
      array('slug'=>'district-of-columbia', 'abbr'=>'DC'),
      array('slug'=>'florida', 'abbr'=>'FL'),
      array('slug'=>'georgia', 'abbr'=>'GA'),
      array('slug'=>'hawaii', 'abbr'=>'HI'),
      array('slug'=>'idaho', 'abbr'=>'ID'),
      array('slug'=>'illinois', 'abbr'=>'IL'),
      array('slug'=>'indiana', 'abbr'=>'IN'),
      array('slug'=>'iowa', 'abbr'=>'IA'),
      array('slug'=>'kansas', 'abbr'=>'KS'),
      array('slug'=>'kentucky', 'abbr'=>'KY'),
      array('slug'=>'louisiana', 'abbr'=>'LA'),
      array('slug'=>'maine', 'abbr'=>'ME'),
      array('slug'=>'maryland', 'abbr'=>'MD'),
      array('slug'=>'massachusetts', 'abbr'=>'MA'),
      array('slug'=>'michigan', 'abbr'=>'MI'),
      array('slug'=>'minnesota', 'abbr'=>'MN'),
      array('slug'=>'mississippi', 'abbr'=>'MS'),
      array('slug'=>'missouri', 'abbr'=>'MO'),
      array('slug'=>'montana', 'abbr'=>'MT'),
      array('slug'=>'nebraska', 'abbr'=>'NE'),
      array('slug'=>'nevada', 'abbr'=>'NV'),
      array('slug'=>'new-hampshire', 'abbr'=>'NH'),
      array('slug'=>'new-jersey', 'abbr'=>'NJ'),
      array('slug'=>'new-mexico', 'abbr'=>'NM'),
      array('slug'=>'new-york', 'abbr'=>'NY'),
      array('slug'=>'north-carolina', 'abbr'=>'NC'),
      array('slug'=>'north-dakota', 'abbr'=>'ND'),
      array('slug'=>'ohio', 'abbr'=>'OH'),
      array('slug'=>'oklahoma', 'abbr'=>'OK'),
      array('slug'=>'oregon', 'abbr'=>'OR'),
      array('slug'=>'pennsylvania', 'abbr'=>'PA'),
      array('slug'=>'rhode-island', 'abbr'=>'RI'),
      array('slug'=>'south-carolina	', 'abbr'=>'SC'),
      array('slug'=>'south-dakota', 'abbr'=>'SD'),
      array('slug'=>'tennessee', 'abbr'=>'TN'),
      array('slug'=>'texas', 'abbr'=>'TX'),
      array('slug'=>'utah', 'abbr'=>'UT'),
      array('slug'=>'vermont', 'abbr'=>'VT'),
      array('slug'=>'virginia', 'abbr'=>'VA'),
      array('slug'=>'washington', 'abbr'=>'WA'),
      array('slug'=>'west-virginia', 'abbr'=>'WV'),
      array('slug'=>'wisconsin', 'abbr'=>'WI'),
      array('slug'=>'wyoming', 'abbr'=>'WY')
   );

   $return = false;   
   $strlen = strlen($short);

   foreach ($states as $state) :
      if ($strlen < 2) {
         return false;
      } else if ($strlen == 2) {
         if (strtolower($state['abbr']) == strtolower($short)) {
            $return = $state['slug'];
            break;
         }   
      } else {
            break;
         }         
   endforeach;
   
   return $return;
} // end function slugifyState()

// WooCommerce Product Loop//
/* Display Add to cart button on archives */ 
add_action('woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_add_to_cart', 10);
/* See Also: ./woocommerce/loop/add-to-cart.php*/
/* Trim Zeros */
add_filter( 'woocommerce_price_trim_zeros', '__return_true' );
//--------//

/*Custom Taxonomy Stuff*/
require_once get_stylesheet_directory().'/product-taxonomies.php';


add_action('wp_enqueue_scripts', function ($hook) {
    wp_enqueue_script( 'custom-wishlist',  get_stylesheet_directory_uri() ."/js/wishlist.js", array('jquery') );
});

/*Extra Fields for Vendor Start*/
// Add extra fields in seller settings
add_action("dokan_settings_after_store_name",function($current_user, $store_settings){
    $user_meta = array();
    $user_meta["primary_discipline"] = get_user_meta( $current_user , 'primary_discipline', true );
    $user_meta["vendor_statement"] = get_user_meta( $current_user , 'vendor_statement', true );
    $user_meta["vendor_bio"] = get_user_meta( $current_user , 'vendor_bio', true );
    $user_meta["accept_commission"] = get_user_meta( $current_user , 'accept_commission', true );
    $user_meta["vendor_exhibition"] = get_user_meta( $current_user , 'vendor_exhibition', true );
    $user_meta["vendor_education"] = get_user_meta( $current_user , 'vendor_education', true );
    $user_meta["vendor_awards"] = get_user_meta( $current_user , 'vendor_awards', true );
    $user_meta["vendor_professional_background"] = get_user_meta( $current_user , 'vendor_professional_background', true );
    $user_meta["vendor_tags"] = get_user_meta( $current_user , 'vendor_tags', true );
    $user_meta["vendor_intro"] = get_user_meta( $current_user , 'vendor_intro', true );
   ?>
    <div class="primary-dicipline dokan-form-group">
        <label class="dokan-w3 dokan-control-label" for="primary_discipline">
            <?php _e( 'Primary Discipline', 'dokan' ); ?>
        </label>
        <div class="dokan-w5 dokan-text-left">
            <?php 
            $args = array(
                'show_option_none'   => '-Select-',
                'option_none_value'  => '',
                'selected'           => $user_meta['primary_discipline'],
                'hierarchical'       => 1, 
                'taxonomy'           => 'product_cat',
                'name'           => 'primary_discipline',
                'hide_empty' => false,
                'class' => 'dokan-form-control',
            );
            $terms  =   get_terms( array(
                'taxonomy' => 'product_cat',
                'hide_empty' => false,
            ) );?>
            <select name="primary_discipline" id="primary_discipline" class="dokan-form-control select2-hidden-accessible">
                <option value="" <?php selected( $user_meta['primary_discipline'], "" ); ?>>-Select-</option>
                <?php 
                foreach ($terms as $term) {?>
                    <option value="<?php echo $term->name ?>" <?php selected( $user_meta['primary_discipline'], $term->name ); ?>><?php echo $term->name ?></option>     
                <?php }
                 ?>
            </select>
            <?php
            //wp_dropdown_categories( $args ); 
             ?>
        </div>
    </div>
    <div class="dokan-form-group">
        <label class="dokan-w3 dokan-control-label" for="vendor_statement">
            <?php _e( 'Artist Statement (About)', 'dokan' ); ?>
        </label>
        <div class="dokan-w5 dokan-text-left">
            <textarea class="dokan-form-control" rows="4" name="vendor_statement"><?php echo esc_attr( $user_meta['vendor_statement'] ); ?></textarea>
        </div>
    </div>
    <div class="dokan-form-group">
        <label class="dokan-w3 dokan-control-label" for="vendor_bio">
            <?php _e( 'Bio', 'dokan' ); ?>
        </label>
        <div class="dokan-w5 dokan-text-left">
            <textarea class="dokan-form-control" rows="4" name="vendor_bio"><?php echo esc_attr( $user_meta['vendor_bio'] ); ?></textarea>
        </div>
    </div>
    <div class="dokan-form-group">
        <label class="dokan-w3 dokan-control-label" for="accept_commission">
            <?php _e( 'Are you currently accepting commissions?', 'dokan' ); ?>
        </label>
        <div class="dokan-w5 dokan-text-left">
            <p class="form-row input-checkbox" id="accept_commission_field" data-priority="">
                <span class="woocommerce-input-wrapper">
                    <label class="checkbox ">
                        <input type="checkbox" class="input-checkbox dokan-form-control" name="accept_commission" id="accept_commission" value="1" <?php echo ($user_meta['accept_commission'])?'checked':''; ?>>
                    </label>
                </span>
            </p>
        </div>
    </div>
    <div class="dokan-form-group">
        <label class="dokan-w3 dokan-control-label" for="vendor_exhibition">
            <?php _e( 'Exhibitions/Shows/Commissions', 'dokan' ); ?>
        </label>
        <div class="dokan-w5 dokan-text-left">
            <textarea class="dokan-form-control" rows="4" name="vendor_exhibition"><?php echo esc_attr( $user_meta['vendor_exhibition'] ); ?></textarea>
        </div>
    </div>
    <div class="dokan-form-group">
        <label class="dokan-w3 dokan-control-label" for="vendor_education">
            <?php _e( 'Education', 'dokan' ); ?>
        </label>
        <div class="dokan-w5 dokan-text-left">
            <textarea class="dokan-form-control" rows="4" name="vendor_education"><?php echo esc_attr( $user_meta['vendor_education'] ); ?></textarea>
        </div>
    </div>
    <div class="dokan-form-group">
        <label class="dokan-w3 dokan-control-label" for="vendor_awards">
            <?php _e( 'Awards & Distinctions', 'dokan' ); ?>
        </label>
        <div class="dokan-w5 dokan-text-left">
            <textarea class="dokan-form-control" rows="4" name="vendor_awards"><?php echo esc_attr( $user_meta['vendor_awards'] ); ?></textarea>
        </div>
    </div>
    <div class="dokan-form-group">
        <label class="dokan-w3 dokan-control-label" for="vendor_professional_background">
            <?php _e( 'Professional Experience', 'dokan' ); ?>
        </label>
        <div class="dokan-w5 dokan-text-left">
            <textarea class="dokan-form-control" rows="4" name="vendor_professional_background"><?php echo esc_attr( $user_meta['vendor_professional_background'] ); ?></textarea>
        </div>
    </div>
    <div class="dokan-form-group">
        <label class="dokan-w3 dokan-control-label" for="vendor_tags">
            <?php _e( 'Artist Tags (keywords)', 'dokan' ); ?>
        </label>
        <div class="dokan-w5 dokan-text-left">
            <textarea class="dokan-form-control" rows="4" name="vendor_tags"><?php echo esc_attr( $user_meta['vendor_tags'] ); ?></textarea>
        </div>
    </div>
    <div class="dokan-form-group">
        <label class="dokan-w3 dokan-control-label" for="vendor_intro">
            <?php _e( 'Introduction Video (Youtube Link)', 'dokan' ); ?>
        </label>
        <div class="dokan-w5 dokan-text-left">
            <input type="text" name="vendor_intro" class="dokan-form-control" value="<?php echo esc_attr( $user_meta['vendor_intro'] ); ?>">
        </div>
    </div>
    <script type="text/javascript">
        jQuery(document).ready(function(){
            jQuery("#primary_discipline").select2({ 'width': '363.083px'});
        });
    </script>
    <?php
},10,2);
//save the field values
add_action( 'dokan_store_profile_saved', 'save_extra_fields', 15 );
function save_extra_fields( $store_id ) {
   /*$dokan_settings = dokan_get_store_info($store_id);
    if ( isset( $_POST['primary_discipline'] ) ) {
        $dokan_settings['primary_discipline'] = $_POST['primary_discipline'];
    }
    if ( isset( $_POST['vendor_statement'] ) ) {
        $dokan_settings['vendor_statement'] = $_POST['vendor_statement'];
    }
    if ( isset( $_POST['vendor_bio'] ) ) {
        $dokan_settings['vendor_bio'] = $_POST['vendor_bio'];
    }
    if ( isset( $_POST['accept_commission'] ) ) {
        $dokan_settings['accept_commission'] = $_POST['accept_commission'];
    }
    if ( isset( $_POST['vendor_exhibition'] ) ) {
        $dokan_settings['vendor_exhibition'] = $_POST['vendor_exhibition'];
    }
    if ( isset( $_POST['vendor_education'] ) ) {
        $dokan_settings['vendor_education'] = $_POST['vendor_education'];
    }
    if ( isset( $_POST['vendor_awards'] ) ) {
        $dokan_settings['vendor_awards'] = $_POST['vendor_awards'];
    }
    if ( isset( $_POST['vendor_professional_background'] ) ) {
        $dokan_settings['vendor_professional_background'] = $_POST['vendor_professional_background'];
    }
    if ( isset( $_POST['vendor_tags'] ) ) {
        $dokan_settings['vendor_tags'] = $_POST['vendor_tags'];
    }
    if ( isset( $_POST['vendor_intro'] ) ) {
        $dokan_settings['vendor_intro'] = $_POST['vendor_intro'];
    }
    update_user_meta( $store_id, 'dokan_profile_settings', $dokan_settings );*/

    update_user_meta( $store_id, 'primary_discipline', $_POST['primary_discipline'] );
    update_user_meta( $store_id, 'vendor_statement', $_POST['vendor_statement'] );
    update_user_meta( $store_id, 'vendor_bio', $_POST['vendor_bio'] );
    update_user_meta( $store_id, 'accept_commission', $_POST['accept_commission'] );
    update_user_meta( $store_id, 'vendor_exhibition', $_POST['vendor_exhibition'] );
    update_user_meta( $store_id, 'vendor_education', $_POST['vendor_education'] );
    update_user_meta( $store_id, 'vendor_awards', $_POST['vendor_awards'] );
    update_user_meta( $store_id, 'vendor_professional_background', $_POST['vendor_professional_background'] );
    update_user_meta( $store_id, 'vendor_tags', $_POST['vendor_tags'] );
    update_user_meta( $store_id, 'vendor_intro', $_POST['vendor_intro'] );
}

//For admin
add_action( 'show_user_profile', 'add_vendor_custom_meta_fields' , 21 );
add_action( 'edit_user_profile', 'add_vendor_custom_meta_fields' , 21 );
function add_vendor_custom_meta_fields($user){
    if ( ! current_user_can( 'manage_woocommerce' ) ) {
        return;
    }

    if ( ! user_can( $user, 'dokandar' ) ) {
        return;
    }
    //$store_settings  = dokan_get_store_info( $user->ID );
    
    $store_settings["primary_discipline"] = get_user_meta( $user->ID , 'primary_discipline', true );
    $store_settings["vendor_statement"] = get_user_meta( $user->ID , 'vendor_statement', true );
    $store_settings["vendor_bio"] = get_user_meta( $user->ID , 'vendor_bio', true );
    $store_settings["accept_commission"] = get_user_meta( $user->ID , 'accept_commission', true );
    $store_settings["vendor_exhibition"] = get_user_meta( $user->ID , 'vendor_exhibition', true );
    $store_settings["vendor_education"] = get_user_meta( $user->ID , 'vendor_education', true );
    $store_settings["vendor_awards"] = get_user_meta( $user->ID , 'vendor_awards', true );
    $store_settings["vendor_professional_background"] = get_user_meta( $user->ID , 'vendor_professional_background', true );
    $store_settings["vendor_tags"] = get_user_meta( $user->ID , 'vendor_tags', true );
    $store_settings["vendor_intro"] = get_user_meta( $user->ID , 'vendor_intro', true );
    ?>
    <h3><?php esc_html_e( 'Extra Vendor Information', 'dokan-lite' ); ?></h3>
    <table class="form-table">
    <tbody>
    <tr>
        <th><?php esc_html_e( 'Primary Discipline', 'dokan-lite' ); ?></th>
        <td>
            <?php 
            $args = array(
                'show_option_none'   => '-Select-',
                'option_none_value'  => '',
                'selected'           => $store_settings['primary_discipline'],
                'hierarchical'       => 1, 
                'taxonomy'           => 'product_cat',
                'name'           => 'primary_discipline',
                'hide_empty' => false
            );
            $terms  =   get_terms( array(
                'taxonomy' => 'product_cat',
                'hide_empty' => false,
            ) );?>
            <select name="primary_discipline" id="primary_discipline" class="dokan-form-control select2-hidden-accessible">
                <option value="" <?php selected( $store_settings['primary_discipline'], "" ); ?>>-Select-</option>
                <?php 
                foreach ($terms as $term) {?>
                    <option value="<?php echo $term->name ?>" <?php selected( $store_settings['primary_discipline'], $term->name ); ?>><?php echo $term->name ?></option>     
                <?php }
                 ?>
            </select>
            <?php
            //wp_dropdown_categories( $args ); 
             ?>

        </td>
    </tr>
    <tr>
        <th><?php esc_html_e( 'Artist Statement (About)', 'dokan-lite' ); ?></th>
        <td>
            <textarea rows="6" name="vendor_statement"><?php echo esc_attr( $store_settings['vendor_statement'] ); ?></textarea>
        </td>
    </tr>
    <tr>
        <th><?php esc_html_e( 'Bio', 'dokan-lite' ); ?></th>
        <td>
            <textarea rows="6" name="vendor_bio"><?php echo esc_attr( $store_settings['vendor_bio'] ); ?></textarea>
        </td>
    </tr>
    <tr>
        <th><?php esc_html_e( 'Are you currently accepting commissions?', 'dokan-lite' ); ?></th>
        <td>
            <p class="form-row input-checkbox" id="accept_commission_field" data-priority="">
                <span class="woocommerce-input-wrapper">
                    <label class="checkbox ">
                        <input type="checkbox" class="input-checkbox " name="accept_commission" id="accept_commission" value="1" <?php echo ($store_settings['accept_commission'])?'checked':''; ?>> Yes
                    </label>
                </span>
            </p>
        </td>
    </tr>
    <tr>
        <th><?php esc_html_e( 'Exhibitions/Shows/Commissions', 'dokan-lite' ); ?></th>
        <td>
            <textarea rows="6" name="vendor_exhibition"><?php echo esc_attr( $store_settings['vendor_exhibition'] ); ?></textarea>
        </td>
    </tr>
    <tr>
        <th><?php esc_html_e( 'Education', 'dokan-lite' ); ?></th>
        <td>
            <textarea rows="6" name="vendor_education"><?php echo esc_attr( $store_settings['vendor_education'] ); ?></textarea>
        </td>
    </tr>
    <tr>
        <th><?php esc_html_e( 'Awards & Distinctions', 'dokan-lite' ); ?></th>
        <td>
            <textarea rows="6" name="vendor_awards"><?php echo esc_attr( $store_settings['vendor_awards'] ); ?></textarea>
        </td>
    </tr>
    <tr>
        <th><?php esc_html_e( 'Professional Experience', 'dokan-lite' ); ?></th>
        <td>
            <textarea rows="6" name="vendor_professional_background"><?php echo esc_attr( $store_settings['vendor_professional_background'] ); ?></textarea>
        </td>
    </tr>
    <tr>
        <th><?php esc_html_e( 'Artist Tags (keywords)', 'dokan-lite' ); ?></th>
        <td>
            <textarea rows="6" name="vendor_tags"><?php echo esc_attr( $store_settings['vendor_tags'] ); ?></textarea>
        </td>
    </tr>
    <tr>
        <th><?php esc_html_e( 'Introduction Video (Youtube Link)', 'dokan-lite' ); ?></th>
        <td>
            <input type="text" name="vendor_intro" class="regular-text" value="<?php echo esc_attr( $store_settings['vendor_intro'] ); ?>">
        </td>
    </tr>
    </tbody>
    </table>
    <script type="text/javascript">
        jQuery(document).ready(function(){
            jQuery("#primary_discipline").select2({ 'width': '25em'});
        });
    </script>
   <?php
}
add_action("dokan_process_seller_meta_fields",function($user_id){
    $post_data = wp_unslash( $_POST );
    //Code to save fields under dokan_prifile_Settings
    /*$store_settings['primary_discipline']   = $post_data['primary_discipline'];
    $store_settings['vendor_statement']     = $post_data['vendor_statement'];
    $store_settings['vendor_bio']           = $post_data['vendor_bio'];
    $store_settings['accept_commission']    = $post_data['accept_commission'];
    $store_settings['vendor_exhibition']    = $post_data['vendor_exhibition'];
    $store_settings['vendor_education']     = $post_data['vendor_education'];
    $store_settings['vendor_awards']        = $post_data['vendor_awards'];
    $store_settings['vendor_professional_background']     = $post_data['vendor_professional_background'];
    $store_settings['vendor_tags']          = $post_data['vendor_tags'];
    $store_settings['vendor_intro']         = $post_data['vendor_intro'];
    update_user_meta( $user_id, 'dokan_profile_settings', $store_settings );*/

    //Code to save fields under user metadata
    update_user_meta( $user_id, 'primary_discipline', $post_data['primary_discipline'] );
    update_user_meta( $user_id, 'vendor_statement', $post_data['vendor_statement'] );
    update_user_meta( $user_id, 'vendor_bio', $post_data['vendor_bio'] );
    update_user_meta( $user_id, 'accept_commission', $post_data['accept_commission'] );
    update_user_meta( $user_id, 'vendor_exhibition', $post_data['vendor_exhibition'] );
    update_user_meta( $user_id, 'vendor_education', $post_data['vendor_education'] );
    update_user_meta( $user_id, 'vendor_awards', $post_data['vendor_awards'] );
    update_user_meta( $user_id, 'vendor_professional_background', $post_data['vendor_professional_background'] );
    update_user_meta( $user_id, 'vendor_tags', $post_data['vendor_tags'] );
    update_user_meta( $user_id, 'vendor_intro', $post_data['vendor_intro'] );
});
/*Extra Fields for Vendor End*/

/*Keep only Simple and variable product in dropdown Start*/
add_filter("dokan_product_types",function($product_types){
    $product_types = array('simple','variable');
    return $product_types;
},200);
/*Keep only Simple and variable product in dropdown End*/

/*Enable stock and default value is 1 start*/
add_action( 'dokan_new_product_added', function($product_id, $data){     
    update_post_meta( $product_id, '_manage_stock', 'yes' );
    update_post_meta( $product_id, '_stock', '1.000000' );
},10,2);
/*Enable stock and default value is 1 End*/

/* remove wp version number from scripts and styles Start */
function remove_css_js_version( $src ) {
    if( strpos( $src, '?ver=' ) )
        $src = remove_query_arg( 'ver', $src );
        $src = add_query_arg( 'ver', rand() ,$src);
    return $src;
}
add_filter( 'style_loader_src', 'remove_css_js_version', 9999 );
add_filter( 'script_loader_src', 'remove_css_js_version', 9999 );
/* remove wp version number from scripts and styles End */



/*Add Product page Tabs start*/
add_filter( 'woocommerce_product_tabs', function ( $tabs ) {
    unset($tabs["additional_information"]);
    unset($tabs["shipping"]);

    $tabs["description"]["title"] = __( 'Artwork Details', 'woocommerce' );
    $tabs['description']['callback'] = 'woo_description_product_tab_content';

    $tabs["seller"]["title"] = __( 'About Artist', 'woocommerce' );
    $tabs['seller']['callback'] = 'woo_seller_product_tab_content';

    $tabs["more_seller_product"]["title"] = __( 'More Artwork', 'woocommerce' );
   // $tabs['more_seller_product']['callback'] = 'woo_artwork_product_tab_content';
    return $tabs;
},100 );
function woo_description_product_tab_content(){
    global $product;
    
    $vendor_id = get_post_field( 'post_author', get_the_id() );
    $vendor_statement   = get_user_meta( $vendor_id , 'vendor_statement', true );
    
    ?>
    <p>
        <?php echo get_the_content(); ?>
    </p>
    <div class="ec_product_data">
        <div class="ec_product_meta">
            <label><b>Weight (lbs)</b></label>
            <span><?php echo $product->get_weight(); ?></span>
        </div>
        <div class="ec_product_meta">
            <label><b>Dimension</b></label>
            <?php 
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
            /*Dimentions Code*/
            ?>
            <span><?php echo $output; ?></span>
        </div>
        <div class="ec_product_meta">
            <label><b>Category</b></label>
            <?php 
            $category_val = "";
            $category = get_the_terms( get_the_ID(), 'product_cat' ); 
            if($category && ! is_wp_error( $category )){
                $category_val = $category[0]->name;
            }
            ?>
            <span><?php echo $category_val; ?></span>
        </div>
        <div class="ec_product_meta">
            <label><b>Medium</b></label>
            <?php 
            $medium_val = "";
            $medium = get_the_terms( get_the_ID(), 'medium' ); 
            if($medium && ! is_wp_error( $medium )){
                $medium_val = $medium[0]->name;
            }
            ?>
            <span><?php echo $medium_val; ?></span>
        </div>
        <div class="ec_product_meta">
            <label><b>Subject</b></label>
            <?php 
            $subject_val = "";
            $subject = get_the_terms( get_the_ID(), 'subject' ); 
            if($subject && ! is_wp_error( $subject )){
                $subject_val = $subject[0]->name;
            }
            ?>
            <span><?php echo $subject_val; ?></span>
        </div>
        <div class="ec_product_meta">
            <label><b>Style</b></label>
            <?php 
            $style_val = "";
            $style = get_the_terms( get_the_ID(), 'style' ); 
            if($style && ! is_wp_error( $style )){
                $style_val = $style[0]->name;
            }
            ?>
            <span><?php echo $style_val; ?></span>
        </div>
        <div class="ec_product_meta">
            <label><b>Type</b></label>
            <?php 
            $type_val = "";
            $type = get_the_terms( get_the_ID(), 'types' ); 
            if($type && ! is_wp_error( $type )){
                $type_val = $type[0]->name;
            }
            ?>
            <span><?php echo $type_val; ?></span>
        </div>
        <div class="ec_product_meta">
            <label><b>Material/Medium</b></label>
            <span><?php echo get_the_excerpt(get_the_ID()); ?></span>
        </div>
        <div class="ec_product_meta">
            <label><b>Ready to hang/install</b></label>
            <span><?php echo ucfirst(get_field('acf_ready_to_hang')) ?></span>
        </div>
        <div class="ec_product_meta">
            <label><b>Signed</b></label>
            <span><?php echo ucfirst(get_field('acf_signed')) ?></span>
        </div>
    </div>
    <?php
}
function woo_seller_product_tab_content(){
    $vendor_id = get_post_field( 'post_author', get_the_id() );
    $vendor_statement   = get_user_meta( $vendor_id , 'vendor_statement', true );
    $vendor = dokan()->vendor->get( $vendor_id );
    
    ?>
    <div class="extra_info statement_info">
        <h4>STATEMENT</h4>
        <p><?php echo $vendor_statement; ?></p>
        <a href="<?php echo $vendor->get_shop_url(); ?>" class="link-red">More About Artist</a>
    </div>
    <?php
}
function woo_artwork_product_tab_content(){

}
/*Add Product page Tabs End*/


add_filter( 'dokan_store_tabs', function($tabs, $store_id){
    unset($tabs['terms_and_conditions']);
    unset($tabs['reviews']);
    $tabs['products']['title'] = __( 'Art', 'dokan' );
    return $tabs;
},100,2 );


add_action( 'woocommerce_before_main_content', function (){
    remove_action( 'woocommerce_before_main_content', 'woocommerce_breadcrumb', 20 );
} );
add_action("init" ,function(){
    remove_action('woocommerce_single_product_summary','woocommerce_template_single_price',10);
    remove_action('woocommerce_single_product_summary','woocommerce_template_single_excerpt',20);
    remove_action('woocommerce_single_product_summary','woocommerce_template_single_meta',40);
    add_action('woocommerce_single_product_summary','woocommerce_template_single_price',29);

    remove_action( 'woocommerce_after_single_product_summary', array( $GLOBALS['et_monarch'], 'display_on_wc_page' ) );
    add_action( 'custom_social_share', array( $GLOBALS['et_monarch'], 'display_on_wc_page' ) );
    
});

/**
 * Change number of related products output
 */ 
function woo_related_products_limit() {
  global $product;
	
	$args['posts_per_page'] = 6;
	return $args;
}
add_filter( 'woocommerce_output_related_products_args', 'jk_related_products_args', 20 );
  function jk_related_products_args( $args ) {
	$args['posts_per_page'] = 4; // 4 related products
	$args['columns'] = 4; // arranged in 2 columns
	return $args;
}

/*State change Product state update*/
//For frontend
add_action( 'dokan_store_profile_saved', 'update_state_vendor_products', 10 );
//For Backend
add_action("dokan_process_seller_meta_fields",'update_state_vendor_products');
function update_state_vendor_products ( $store_id ) {
    wp_schedule_single_event( time() + 30, 'update_state_in_products', array( $store_id) );
}
function do_this_in_thirty_secs( $store_id ) {
    if(is_null($store_id) || empty($store_id)){
        return;
    }
    $dokan_profile_settings =  get_user_meta( $store_id, 'dokan_profile_settings', true );
    if($dokan_profile_settings['address']['state']){
        $country_obj = new WC_Countries();
        $countries   = $country_obj->countries;
        $states      = $country_obj->states;
        $country_code = $dokan_profile_settings['address']['country'];
        $state_code = $dokan_profile_settings['address']['state'];
        $state_name   = isset( $states[ $country_code ][ $state_code ] ) ? $states[ $country_code ][ $state_code ] : $state_code;
        $args = array(
            'post_type' => 'product',
            'posts_per_page' => -1,
            'author'    => $store_id
        );
        $loop = new WP_Query( $args );
        $products = $loop->posts;
        $taxonomy = "state";
        $state = term_exists( $state_name, $taxonomy );
        if(!$state){
            $new_state = wp_insert_term(
                $state_name,   // the term 
                $taxonomy, // the taxonomy
            );
            $new_state_term_id = $new_state['term_id'];
        }else{
            $new_state = get_term_by('name', $state_name, $taxonomy);
            $new_state_term_id = $new_state->term_id;
        }
        foreach ($products as $product) {
            wp_set_post_terms( $product->ID, array(), $taxonomy );
            wp_set_post_terms( $product->ID, array((int)$new_state_term_id), $taxonomy );
        }
    }else{
        $taxonomy = "state";
        $args = array(
            'post_type' => 'product',
            'posts_per_page' => -1,
            'author'    => $store_id
        );

        $loop = new WP_Query( $args );
        $products = $loop->posts;
        foreach ($products as $product) {
            wp_set_post_terms( $product->ID, array(), $taxonomy );
        }
    }
}
add_action( 'update_state_in_products', 'do_this_in_thirty_secs', 10 );

/*State change Product state update*/

/*new Product state update*/
add_action("dokan_new_product_added",function($product_id){
    $vendor_id = get_post_field( 'post_author', $product_id );
    $dokan_profile_settings =  get_user_meta( $vendor_id, 'dokan_profile_settings', true );
    if($dokan_profile_settings['address']['state']){
        $country_obj = new WC_Countries();
        $countries   = $country_obj->countries;
        $states      = $country_obj->states;
        $country_code = $dokan_profile_settings['address']['country'];
        $state_code = $dokan_profile_settings['address']['state'];
        $state_name   = isset( $states[ $country_code ][ $state_code ] ) ? $states[ $country_code ][ $state_code ] : $state_code;
        $taxonomy = "state";
        $state = term_exists( $state_name, $taxonomy );
        if(!$state){
            $new_state = wp_insert_term(
                $state_name,   // the term 
                $taxonomy, // the taxonomy
            );
            $new_state_term_id = $new_state['term_id'];
        }else{
            $new_state = get_term_by('name', $state_name, $taxonomy);
            $new_state_term_id = $new_state->term_id;
        }
        wp_set_post_terms( $product_id, array(), $taxonomy );
        wp_set_post_terms( $product_id, array((int)$new_state_term_id), $taxonomy );
        
    }else{
        $taxonomy = "state";
        wp_set_post_terms( $product_id, array(), $taxonomy );
    }
});
/*new Product state update*/

// Shop random order. View settings drop down order by Woocommerce > Settings > Products > Display
add_filter( 'woocommerce_get_catalog_ordering_args', 'custom_woocommerce_get_catalog_ordering_args' );
function custom_woocommerce_get_catalog_ordering_args( $args ) {
    $orderby_value = isset( $_GET['orderby'] ) ? woocommerce_clean( $_GET['orderby'] ) : apply_filters( 'woocommerce_default_catalog_orderby', get_option( 'woocommerce_default_catalog_orderby' ) );
    if ( 'random_list' == $orderby_value ) {
        $args['orderby'] = 'rand';
        $args['order'] = '';
        $args['meta_key'] = '';
    }
    return $args;
}
add_filter( 'woocommerce_default_catalog_orderby_options', 'custom_woocommerce_catalog_orderby',5 );
add_filter( 'woocommerce_catalog_orderby', 'custom_woocommerce_catalog_orderby',5 );
function custom_woocommerce_catalog_orderby( $sortby ) {
    $sortby['random_list'] = 'Default';
    return $sortby;
}
