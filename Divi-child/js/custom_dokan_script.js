jQuery(document).ready(function () {
  console.log("Success! js/custom_dokan_script called.");
});

/*TEMP DISABLED 24AUG2022
var requiredNames = [
    "post_title",
    "_regular_price",
    "acf_width",
    "acf_height",
    "acf_length",
 ];


for (var i = 0; i < requiredNames.length; i++) {
	let dokanField = document.getElementsByName(requiredNames[i])[0];
	let att = document.createAttribute("required");
	att.value = "required";
	dokanField.setAttributeNode(att);
    console.log(requiredNames[i]);
};

let submitBtn = document.getElementById("mb_dokan_submit");

let inventoryBtn = document.getElementById("inventorycheat");

inventoryBtn.addEventListener("click", function () {
	console.log("Wow! You clicked inventory!");
	document.getElementById("_manage_stock").checked = true;
	document.getElementById("_stock").value="1";
	document.getElementById("inventory_success").classList.remove("mbatt-hidden");
	document.querySelector(".mbatt-hide-stock").classList.add("mbatt-hidden");
});*/

/*
// Log a list of Term Wraps
let listTermWraps = document.getElementsByClassName("term-wrap");

for (var i = 0; i < listTermWraps.length; i++) {
	let myTerm = listTermWraps[i];
	let fetchAttribute = myTerm.getAttribute("data-tax");
    console.log(fetchAttribute);
};
*/
// Check if at least one radio is checked under each Term Wrap

// Counting checked radios
/*function checkTaxonomies() {
    var inputs = document.getElementById("form").elements;
    var count  = 0;
    for (var i = 0; i < inputs.length; i++) {
        if (inputs[i].type == 'radio' && inputs[i].checked) {
            count++;
        }
    }
    alert(count);
}*/

/*       
    var arttitle = jQuery("input[name='post_title']").val();
    var artdec = jQuery("textarea[name='product_description']").val();
    var product_excerpt = jQuery("textarea[name='product_excerpt']").val();
    var regular_price = jQuery("input[name='_regular_price']").val();
    
    var wei = jQuery("input[name='_weight']").val();
    var height = jQuery("input[name='_height']").val();
    var wid = jQuery("input[name='_width']").val();
    var leng = jQuery("input[name='_length']").val();
    var shipping_typeee = jQuery("#shipping_type");
    
   
    
    if(arttitle == ''){
        alert("Oops! You missed something; [Go to Artwork Title] ");
      return false;
    }else{
      if(arttitle.length > 50){
          alert("Sorry, the Artwork Title must be less than 50 characters long. Yours is " + arttitle.length);
        return false;
      }
      
    }
      
     if(artdec == ''){
        alert("Oops! You missed something; [Go to Artwork Description]");
       return false;
    }
    
         
      if(jQuery(".upload_image_id").val() == ""){
      alert("Oops! You missed something; [Go to Click to upload Image]");
      return false;
    } 
    
      if(product_excerpt == ''){
        alert("Oops! You missed something; [Go to Material/Medium] ");
       return false;
    }
         if(regular_price == ''){
        alert("Oops! You missed something; [Go to (General) Retail Price($)] ");
       return false;
    }
     var is_original = jQuery('input:radio[name="_is_original"]:checked').val();
    
      if(typeof is_original == "undefined" || jQuery('input:radio[name="_is_original"]:checked').val() == ""){
       alert("Oops! You missed something; [Go to (Inventory) Is this an Original Piece]");
      return false;
    }

    
    

     if(wei == ''){
        alert("Oops! You missed something; [Go to (Shipping)  ̣Weight (lbs)] ");
       return false;
    }
       if(height == ''){
        alert("Oops! You missed something; [Go to (Shipping) Height]");
       return false;
    }

       if(wid == ''){
        alert("Oops! You missed something; [Go to (Shipping) Width]");
       return false;
    }
       if(leng == ''){
        alert("Oops! You missed something; [Go to (Shipping) Depth]");
       return false;
    }

        if (shipping_typeee.val() == "") {
        alert("Oops! You missed something; [Go to (Shipping) Shipping Method!] ");
        return false;
    } 
    
    
   if(jQuery(".product_cat").find('input[type="radio"]:checked').length == 0){
      alert("Oops! You missed something; [Go to Main Artwork Category]");
      return false;
    }  
    
    if(jQuery(".medium").find('input[type="checkbox"]:checked').length == 0){
      alert("Oops! You missed something; [Go to Medium Category]");
      return false;
    }  
     if(jQuery(".subject").find('input[type="checkbox"]:checked').length == 0){
      alert("Oops! You missed something; [Go to Subject Category]");
      return false;
    } 
    
       if(jQuery(".style").find('input[type="checkbox"]:checked').length == 0){
      alert("Oops! You missed something; [Go to Style Category]");
      return false;
    }
    
        if(jQuery(".types").find('input[type="checkbox"]:checked').length == 0){
      alert("Oops! You missed something; [Go to Type Category]");
      return false;
    }  
       if(jQuery(".color").find('input[type="checkbox"]:checked').length == 0){
      alert("Oops! You missed something; [Go to color Category]");
      return false;
    }  
    
       if(jQuery(".size").find('input[type="checkbox"]:checked').length == 0){
      alert("Oops! You missed something; [Go to Size Category]");
      return false;
    }  
    
         if(jQuery(".orientation").find('input[type="checkbox"]:checked').length == 0){
      alert("Oops! You missed something; [Go to Orientation Category] ");
      return false;
    }  
   
       if(jQuery('.product_tag ').find(':selected').length == 0)
    {
      alert("Oops! You missed something; [Go to Artwork Tags (Keywords)]");
      return false;
    }  
    
  });
*/

/*TEMP DISABLED 24AUG2022
console.log("220207-0747");
let shippoLabel=document.querySelector(".marketship-shipping-options label[for=shippo]");
shippoLabel.innerHTML="<b>Live Shipping Rates</b> &mdash; EC calculates live shipping rates based on package dimensions, weight, and zip codes."
document.querySelector("label[for=_additional_product_price]").innerHTML="Shipping Cost ($):"
*/
