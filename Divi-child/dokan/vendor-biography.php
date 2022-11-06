<?php
//extra fields

/**
 * The Template for displaying vendor biography.
 *
 * @package dokan
 */

$store_user = get_userdata( get_query_var( 'author' ) );
$store_info   = dokan_get_store_info( $store_user->ID );
$map_location = $store_user->get_location();
$layout       = get_theme_mod( 'store_layout', 'left' );

//extra fields
$vendor_id = $store_user->ID;
$accept_commission = get_user_meta($vendor_id, 'accept_commission', true);
$vendor_statement = get_user_meta($vendor_id, 'vendor_statement', true);
$vendor_bio = get_user_meta($vendor_id, 'vendor_bio', true);
$vendor_exhibition = get_user_meta($vendor_id, 'vendor_exhibition', true);
$vendor_education = get_user_meta($vendor_id, 'vendor_education', true);
$vendor_awards = get_user_meta($vendor_id, 'vendor_awards', true);
$vendor_professional_background = get_user_meta($vendor_id, 'vendor_professional_background', true);
$vendor_tags = get_user_meta($vendor_id, 'vendor_tags', true);
$vendor_intro = get_user_meta($vendor_id, 'vendor_intro', true);


get_header( 'shop' );
?>

<?php do_action( 'woocommerce_before_main_content' ); ?>

<div class="dokan-store-wrap layout-<?php echo esc_attr( $layout ); ?>">

    <?php if ( 'left' === $layout ) { ?>
        <?php dokan_get_template_part( 'store', 'sidebar', array( 'store_user' => $store_user, 'store_info' => $store_info, 'map_location' => $map_location ) ); ?>
    <?php } ?>

<div id="dokan-primary" class="dokan-single-store">
    <div id="dokan-content" class="store-review-wrap woocommerce" role="main">

        <?php dokan_get_template_part( 'store-header' ); ?>

        <div id="vendor-biography">
            <div id="comments" class="extra_info">
            <?php do_action( 'dokan_vendor_biography_tab_before', $store_user, $store_info ); ?>

            <h3 class="headline"><?php echo apply_filters( 'dokan_vendor_biography_title', __( 'ABOUT THE ARTIST', 'dokan' ) ); ?></h3>

            	<div class="mbatt-bio-extra">    	
            	<!--
					<h4>accept_commission</h4>
            		<p><?php echo nl2br($accept_commission); ?></p>
				-->
                <?php
                if($accept_commission)
					{
						?>
						<div><h4>Artist accepts commissions.</h4></div>
						<?php
					}
                if($vendor_statement)
					{
						?>
                			<h4>STATEMENT</h4>
            				<p><?php echo nl2br($vendor_statement); ?></p>
						<?php
					}
                if($vendor_bio)
					{
						?>
							<h4>BIO</h4>
            				<p><?php echo nl2br($vendor_bio); ?></p>
						<?php
					}
                if($vendor_exhibition)
					{
						?>
							<h4>EXHIBITIONS/SHOWS/COMMISSIONS</h4>
            				<p><?php echo nl2br($vendor_exhibition); ?></p>
						<?php
					}
                if($vendor_education)
					{
						?>
							<h4>EDUCATION</h4>
            				<p><?php echo nl2br($vendor_education); ?></p>
						<?php
					}
                if($vendor_awards)
					{
						?>
							<h4>AWARDS</h4>
            				<p><?php echo nl2br($vendor_awards); ?></p>
						<?php
					}
                if($vendor_professional_background)
					{
						?>
							<h4>PROFESSIONAL EXPERIENCE</h4>
            				<p><?php echo nl2br($vendor_professional_background); ?></p>
						<?php
					}
                if($vendor_tags)
					{
						?>
							<h4>TAGS</h4>
            				<p><?php echo nl2br($vendor_tags); ?></p>
						<?php
					}
               if($vendor_intro!='')
					{
						$url =str_replace("youtu.be/","youtube.com/watch?v=",$vendor_intro);	
						$parts = parse_url($url);
						parse_str($parts['query'], $query);
						
						if(isset($query['v']))
						{
						?>
						<div class="extra_info">
							<h4>INTRO VIDEO</h4>
							<?php
								if($url!='')
								{
									?>
									<iframe src="https://www.youtube.com/embed/<?php echo $query['v']; ?>" width="100%" height="500px" frameborder="0"  allowfullscreen ng-show="showvideo"></iframe>
									<?php	
								}		
							?>
						</div>
                <?php	
						}
               		}
               ?>
            
            <?php do_action( 'dokan_vendor_biography_tab_after', $store_user, $store_info ); ?>
        	           
        	</div>
        </div>

    </div><!-- #content .site-content -->
</div><!-- #primary .content-area -->

    <?php if ( 'right' === $layout ) { ?>
        <?php dokan_get_template_part( 'store', 'sidebar', array( 'store_user' => $store_user, 'store_info' => $store_info, 'map_location' => $map_location ) ); ?>
    <?php } ?>

</div><!-- .dokan-store-wrap -->

<?php do_action( 'woocommerce_after_main_content' ); ?>

<?php get_footer(); ?>
