<?php
  require_once 'core/init.php';
  include 'includes/head.php';
  include 'includes/navigation.php';
  include 'includes/headerpartial.php';

?>

<div class="col-md-12">
  <div class="row">
    <h2 class="text-center">My Shopping Cart</h2><hr>
    <?php if($cart_id == ''): ?>
      <div class="bg-danger">
        <p class="text-center text-danger">Your shopping cart is empty!</p>
      </div>
      <br>
      <br>
      <p class="text-center"><a href="/boutique/index.php" alt="home">Visit Site</a></p>
    <?php else: ?>
      <table class="table table-bordered table-condensed table-striped">
        <thead><th>#</th><th>Item</th><th>Price</th><th>Quantity</th><th>Size</th><th>Sub Total</th></thead>
        <tbody></tbody>
      </table>

    <?php endif; ?>
  </div>
</div>

<?php include 'includes/footer.php'; ?>
