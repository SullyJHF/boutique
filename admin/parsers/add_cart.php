<?php
  require_once $_SERVER['DOCUMENT_ROOT'].'/boutique/core/init.php';
$product_id = sanitize($_POST['product_id']);
$size = sanitize($_POST['size']);
$available = sanitize($_POST['available']);
$quantity = sanitize($_POST['quantity']);
$item = array();
$item[] = array(
  'id'        => $product_id,
  'size'      => $size,
  'quantity'  => $quantity,

);
$domain = ($_SERVER['HTTP_HOST'] != 'localhost')?'.'.$_SERVER['HTTP_HOST']:false;//check if is localhost or not
$query = $db->query("SELECT * FROM products WHERE id = '{$product_id}'");
$product = mysqli_fetch_assoc($query);
$_SESSION['success_flash'] = $product['title']. ' was added to your cart.';

//check to see if the cart cookie exists
if($cart_id != ''){
  $cartQ = $db->query("SELECT * FROM cart WHERE id = '{$cart_id}'");//grab the cart id if exists
  $cart = mysqli_fetch_assoc($cartQ);
  $previous_items = json_decode($cart['items'],true);//grab the previous items that are in cart already and decode them
  $item_match = 0;//check if the items mathces with items from database....start with 0
  $new_items = array();
  foreach($previous_items as $pitem){
    if($item[0]['id'] == $pitem['id'] && $item[0]['size'] == $pitem['size']){
      $pitem['quantity'] = $pitem['quantity'] + $item[0]['quantity'];
      if($pitem['quantity'] > $available){
        $pitem['quantity'] = $available;//if they try to get more than available set it to available Quantity
      }
      $item_match = 1;
    }
    $new_items[] = $pitem;
  }
  if($item_match != 1){//that means if is a new item
    $new_items = array_merge($item,$previous_items);//merge the item with the previous items
  }
  //needs to encode them
  $items_json = json_encode($new_items);
  $cart_expire = date("Y-m-d H:i:s", strtotime("+30 days"));//set up the expire date
  $db->query("UPDATE cart SET items = '{$items_json}', expire_date = '{$cart_expire}' WHERE id = '{$cart_id}'");//update the databse with the new expire date
  setcookie(CART_COOKIE,'',1,"/",$domain, false);//that destroy the cookie
  setcookie(CART_COOKIE,$cart_id,CART_COOKIE_EXPIRE,'/', $domain, false);//set the cookie
}else{
  //add cart to the database and set cookie
  $items_json = json_encode($item);
  $cart_expire = date("Y-m-d H:i:s",strtotime("+30 days"));
  $db->query("INSERT INTO cart (items, cart_expire) VALUES ('{$items_json}','{$cart_expire}')");//this insert the cart into database
  $cart_id = $db->insert_id;//insert the last id (from the previous line of code) into database
  setcookie(CART_COOKIE,$cart_id,CART_COOKIE_EXPIRE,'/',$domain,false);//set the cookie with name, value, exipre date, path, domain
}
?>
