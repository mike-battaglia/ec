<?php
/**
 *  Dokan Dashboard Template
 *
 *  Dokan Main Dashboard template for Fron-end
 *
 *  @since 2.4
 *
 *  @package dokan
 */
?>
<?php do_action( 'dokan_dashboard_wrap_start' ); ?>

    <div class="dokan-dashboard-wrap">
        <?php

            /**
             *  dokan_dashboard_content_before hook
             *
             *  @hooked get_dashboard_side_navigation
             *
             *  @since 2.4
             */
            do_action( 'dokan_dashboard_content_before' );
        ?>

        <div class="dokan-dashboard-content">

            <?php

                /**
                 *  dokan_dashboard_content_before hook
                 *
                 *  @hooked show_seller_dashboard_notice
                 *
                 *  @since 2.4
                 */
                do_action( 'dokan_dashboard_content_inside_before' );
            ?>

            <article class="dashboard-content-area">
				
                       
  <?php
/*
 * 
 * If the vendor does not have a shipping address, then display notice.
 *
 *  /

  /* fetch the user address*/
  $this_user = get_current_user_id();
  $user_id = $this_user;
  $key = 'marketship_origin_address';
  $single = false;
  $user_meta = get_user_meta( $user_id, $key, $single );
  $jackpot = $user_meta[0]['street1'];
/*
  echo '<p>The '. $key . ' value for user id ' . $user_id . ' is: ' . $jackpot . '</p>';
  print_r($user_meta);
  echo '<p>---</p>';
  print_r($jackpot);
/*
/*display message if address is empty*/
  if ( empty($jackpot) ) {
  	echo '<p class ="mbatt-warning"><b>Notice:</b>
    <br>In order to display live shipping rates, you need to enter your shipping address.
	<br>Please go to <a href="/dashboard/settings/store/#dokan_address[street_1]"><i class="fa fa-cog"></i> Settings</a> and enter your information.</p>';
  }
?>

                <?php

                    /**
                     *  dokan_dashboard_before_widgets hook
                     *
                     *  @hooked dokan_show_profile_progressbar
                     *
                     *  @since 2.4
                     */
                    do_action( 'dokan_dashboard_before_widgets' );
                ?>

                <div class="dokan-w6 dokan-dash-left">

                    <?php

                        /**
                         *  dokan_dashboard_left_widgets hook
                         *
                         *  @hooked get_big_counter_widgets
                         *  @hooked get_orders_widgets
                         *  @hooked get_products_widgets
                         *
                         *  @since 2.4
                         */
                        do_action( 'dokan_dashboard_left_widgets' );
                    ?>

                </div> <!-- .col-md-6 -->

                <div class="dokan-w6 dokan-dash-right">
                    <?php
                        /**
                         *  dokan_dashboard_right_widgets hook
                         *
                         *  @hooked get_sales_report_chart_widget
                         *
                         *  @since 2.4
                         */
                        do_action( 'dokan_dashboard_right_widgets' );
                    ?>

                </div>

            </article><!-- .dashboard-content-area -->

             <?php

                /**
                 *  dokan_dashboard_content_inside_after hook
                 *
                 *  @since 2.4
                 */
                do_action( 'dokan_dashboard_content_inside_after' );
            ?>


        </div><!-- .dokan-dashboard-content -->

        <?php

            /**
             *  dokan_dashboard_content_after hook
             *
             *  @since 2.4
             */
            do_action( 'dokan_dashboard_content_after' );
        ?>

    </div><!-- .dokan-dashboard-wrap -->

<?php do_action( 'dokan_dashboard_wrap_end' ); ?>
