<?php
/**
 * Dokan Seller Single product tab Template
 *
 * @since 2.4
 *
 * @package dokan
 */

//extra fields
$pvendor_id = $author->ID ;
$qaccept_commission = get_user_meta($pvendor_id, 'accept_commission', true);
$qvendor_statement = get_user_meta($pvendor_id, 'vendor_statement', true);
$qvendor_bio = get_user_meta($pvendor_id, 'vendor_bio', true);
$qvendor_exhibition = get_user_meta($pvendor_id, 'vendor_exhibition', true);
$qvendor_education = get_user_meta($pvendor_id, 'vendor_education', true);
$qvendor_awards = get_user_meta($pvendor_id, 'vendor_awards', true);
$qvendor_professional_background = get_user_meta($pvendor_id, 'vendor_professional_background', true);
$qvendor_tags = get_user_meta($pvendor_id, 'vendor_tags', true);
$qvendor_intro = get_user_meta($pvendor_id, 'vendor_intro', true);

?>

<h2><?php esc_html_e( 'Artist Biography', 'dokan-lite' ); ?></h2>

<div id="vendor-biography">
            <div id="comments" class="extra_info">

            	<div class="mbatt-bio-extra">    	
            	<!--
					<h4>accept_commission</h4>
            		<p><?php echo nl2br($qaccept_commission); ?></p>
				-->
                <?php
                if($qaccept_commission)
					{
						?>
						<div><h4>Artist accepts commissions.</h4></div>
						<?php
					}
                if($qvendor_statement)
					{
						?>
                			<h4>STATEMENT</h4>
            				<p><?php echo nl2br($qvendor_statement); ?></p>
						<?php
					}
                if($qvendor_bio)
					{
						?>
							<h4>BIO</h4>
            				<p><?php echo nl2br($qvendor_bio); ?></p>
						<?php
					}
                if($vendor_exhibition)
					{
						?>
							<h4>EXHIBITIONS / SHOWS / COMMISSIONS</h4>
            				<p><?php echo nl2br($qvendor_exhibition); ?></p>
						<?php
					}
                if($vendor_education)
					{
						?>
							<h4>EDUCATION</h4>
            				<p><?php echo nl2br($qvendor_education); ?></p>
						<?php
					}
                if($vendor_awards)
					{
						?>
							<h4>AWARDS</h4>
            				<p><?php echo nl2br($qvendor_awards); ?></p>
						<?php
					}
                if($qvendor_professional_background)
					{
						?>
							<h4>PROFESSIONAL EXPERIENCE</h4>
            				<p><?php echo nl2br($qvendor_professional_background); ?></p>
						<?php
					}
                if($vendor_tags)
					{
						?>
							<h4>TAGS</h4>
            				<p><?php echo nl2br($qvendor_tags); ?></p>
						<?php
					}
               if($qvendor_intro!='')
					{
						$url =str_replace("youtu.be/","youtube.com/watch?v=",$qvendor_intro);	
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