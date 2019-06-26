  </div><br><br>

<div class="col-md-12 text-center">&copy; Copyright 2018-2020 Dragos's Boutique</div>

<!--Details Modal-->



<script>
jQuery(window).scroll(function(){
  var vscroll = jQuery(this).scrollTop();
jQuery('#logotext').css({
  "transform" : "translate(0px, "+vscroll/2+"px)"
});

var vscroll = jQuery(this).scrollTop();
jQuery('#back-flower').css({
"transform" : "translate("+vscroll/5+"px, -"+vscroll/12+"px)"
});

var vscroll = jQuery(this).scrollTop();
jQuery('#for-flower').css({
"transform" : "translate(0px, -"+vscroll/2+"px)"
});
});



function detailsmodal(id){
  var data = {"id" : id};
  jQuery.ajax({
    url : '/boutique/includes/detailsmodal.php', //is the url of the detailsmodal page....where the page is living
    method : "post",
    data : data,//is assigning the data from "var data" to data
    success : function(data){
      jQuery('body').append(data);//appending the 'data' to the body of the modal...basically the body in this case is the code from detailsmodal
      jQuery('#details-modal').modal('toggle');//is opening the modal(which has the id details-modal from details-modal page in top)using the modal function of bootstrap
    },
    error : function(){
      alert("Something went wrong!");
    },
  });
}

function add_to_cart(){
  jQuery('#modal_errors').html("");
  var size  = jQuery('#size').val();
  var quantity  = jQuery('#quantity').val();
  var available  = jQuery('#available').val();
  var error = '';
  var data = jQuery('#add_product_form').serialize();//thi is to take the data from the form and this serialize jQuery function id taking those values to use them
  if(size == '' || quantity == '' || quantity == 0){
    error += '<p class="text-danger text-center">You must choose a size and quantity.</p>';
    jQuery('#modal_errors').html(error);
    return;
  }else if(quantity > available){
    error += '<p class="text-danger text-center">There are only '+available+' available.</p>';
    jQuery('#modal_errors').html(error);
    return;
  }else{
    jQuery.ajax({
      url : '/boutique/admin/parsers/add_cart.php',
      method : 'post',
      data : data,
      success : function(){
        location.reload();
      },
      error : function(){alert("Something went wrong");}
    });
  }
}
</script>
  </body>

</html>
