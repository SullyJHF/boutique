<?php
require_once '../core/init.php';//this is to have access to the db from init.php
$id = $_POST['id'];//we need post bcz is a form and we need to access it
$id = (int)$id;//this is for security to be sure that is a number and not a string or something else
$sql = "SELECT * FROM products WHERE id = '$id'";//selecting from products table the product with id 1 or 2 etc
$result = $db->query($sql);//we execute the statement or the query from above and store it in result
$product = mysqli_fetch_assoc($result);//is taking the result from query and turn it in an associative array and send it to product
$brand_id = $product['brand'];
$sql = "SELECT brand FROM brand WHERE id = '$brand_id'";
$brand_query = $db->query($sql);
$brand = mysqli_fetch_assoc($brand_query);
$sizestring = $product['sizes'];
$sizestring = rtrim($sizestring,',');
$size_array = explode(',', $sizestring);
?>

<?php ob_start(); ?><!--is starting a buffer for all the code-->
<div class="modal fade details-1" id="details-modal" tabindex="-1" role="dialog" aria-labelledby="details-1" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
    <div class="modal-header">
      <button class="close" type="button" onclick="closeModal()" aria-label="Close">
        <span aria-hidden="true">&times;</span>
      </button>
      <h4 class="modal-title text-center"><?= $product['title']; ?></h4>
    </div>
    <div class="modal-body">
      <div class="container-fluid">
        <div class="row">
          <div class="col-sm-6">
            <div class="center-block">
              <img src="<?= $product['image']; ?>" alt="<?= $product['title']; ?>" class="details img-responsive">
            </div>
          </div>
          <div class="col-sm-6">
            <h4>Details</h4>
            <p><?=nl2br($product['description']); ?></p>
            <hr>
            <p>Price: $<?= $product['price']; ?></p>
            <p>Brand: <?= $brand['brand']; ?></p>
            <form  action="add_cart.php" method="post"><!--when the form has to have class and when no ?-->
              <div class="form-group">
                <div class="col-xs-3"><label for="quantity">Quantity:</label>
                  <input type="number" class="form-control" id="quantity" name="quantity" min='0'>
                </div>
                  <br>
                  <div class="col-xs-9">&nbsp</div><!--nbsp is non breaking spave so that means all theese col xs 9 will stick together-->
              </div><br><br>
              <div class="form-group">
                <label for="size">Size</label>
                <select name="size" id="size" class="form-group" >
                  <option value=""></option>
                  <?php foreach($size_array as $string) {
                    $string_array = explode(':', $string);
                    $size = $string_array[0];
                    $quantity = $string_array[1];
                    echo '<option value="'.$size.'">'.$size.' ('.$quantity.' Available)</option>';
                  } ?>
                </select>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
    <div class="modal-footer">
      <button class="btn btn-default" onclick="closeModal()">Close</button>
      <button class="btn btn-warning" type="submit"><span class="glyphicon glyphicon-shopping-cart"></span>Add To Cart</button>
    </div>
  </div>
  </div>
</div>
<script>
  function closeModal(){
    jQuery('#details-modal').modal('hide');//so if i understand right first is hide the modal and after is remove it....why u need first to hide it ?
    setTimeout(function(){
      jQuery('#details-modal').remove();
      jQuery('.modal-backdrop').remove();
    }, 500);
  }
</script>
<?php echo ob_get_clean(); ?><!--is cleaning the buffer-->
