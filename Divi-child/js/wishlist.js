jQuery(document).ready(function(){
    jQuery(".wishlist_updator").click(function(e){
        e.preventDefault();
        var prod_id = jQuery(this).attr("data-prod_id");
        //window.woocommerce_wishlist_add_to_wishlist_url = jQuery(this).attr("data-form_url");
        jQuery(".wl-list-pop").html(jQuery("#wishlist-content-"+prod_id).html());
        jQuery(".wl-list-pop").find('form').addClass('cart')
        jQuery(".wl-list-pop").addClass('wl_custom_args');
    });
});
jQuery("body").on("click",".wl-add-to-single", function(e){
    if(!jQuery(this).parents(".wl-list-pop").hasClass("wl_custom_args")){
        return;
    }
    e.preventDefault();
  var listid = jQuery(this).attr("data-listid");
  jQuery(document).find(".wl_custom_args").find("form.cart").find("input#wlid").val(listid);
  jQuery(document).find(".wl_custom_args").find("form.cart").submit();
});
