<?php
ob_start();
session_start();
include('includes/dbconnect.php');
include('includes/common_functions.php');

$user_id = null;
if (isset($_SESSION['username'])) {
  $username = $_SESSION['username'];
  $stmt = $con->prepare("SELECT `user_id` FROM `ecom_users` WHERE `user_username`=?");
  $stmt->bind_param('s', $username);
  $stmt->execute();
  $result = $stmt->get_result();
  if ($result->num_rows > 0) {
    $user_data = $result->fetch_assoc();
    $user_id = $user_data['user_id'];
  }
}

// Fetch Cart Items
$totalPrice = 0;
$cartItems = [];
// for logged in user
if ($user_id) {
  $stmt = $con->prepare("SELECT p.product_id,p.product_title,p.product_price,p.product_image_1, c.quantity FROM ecom_cart_details c JOIN ecom_products p ON p.product_id = c.product_id WHERE c.user_id=?");
  $stmt->bind_param('i', $user_id);
  $stmt->execute();
  $result = $stmt->get_result();
  while ($row = $result->fetch_assoc()) {
    $cartItems[] = $row;
    $totalPrice += $row['product_price'] * $row['quantity'];
  }
} else if (!empty($_SESSION['cart'])) {
  // for guest user
  $ids = implode(",", array_keys($_SESSION['cart']));
  $query = "SELECT * FROM ecom_products WHERE product_id IN ($ids)";
  $result = mysqli_query($con, $query);
  while ($row = mysqli_fetch_assoc($result)) {
    $row['quantity'] = $_SESSION['cart'][$row['product_id']];
    $cartItems[] = $row;
    $totalPrice += $row['product_price'] * $row['quantity'];
  }
}

if (isset($_POST['update-cart']) && isset($_POST['qty'])) {
  // echo "update is working";
  foreach ($_POST['qty'] as $pid => $qty) {
    $pid = (int)$pid;
    $qty = (int)$qty;
    if ($qty <= 0) continue;
    if ($user_id) {
      $stmt = $con->prepare("UPDATE `ecom_cart_details` SET quantity=? WHERE user_id=? AND product_id=?");
      $stmt->bind_param('iii', $qty, $user_id, $pid);
      $stmt->execute();
    } else {
      $_SESSION['cart'][$pid] = $qty;
    }
  }
  $_SESSION['toast-message'] = "Cart Updated";
  $_SESSION['toast-icon'] = "success";
  header("Location: cart.php");
  exit();
}

// delete cart item
if (isset($_GET['deleteItem'])) {
  $pid = (int)$_GET['deleteItem'];
  if ($user_id) {
    $stmt = $con->prepare("DELETE FROM `ecom_cart_details` WHERE user_id=? AND product_id=?");
    $stmt->bind_param('ii', $user_id, $pid);
    $stmt->execute();
  } else {
    unset($_SESSION['cart'][$pid]);
  }
  $_SESSION['toast-message'] = "Item Removed From Cart";
  $_SESSION['toast-icon'] = "error";
  header("Location: cart.php");
  exit();
}

// delete multiple items
if (isset($_POST['remove-selected']) && isset($_POST['remove'])) {
  foreach ($_POST['remove'] as $pid) {
    $pid = (int)$pid;
    if ($user_id) {
      $stmt = $con->prepare("DELETE FROM `ecom_cart_details` WHERE user_id=? AND product_id=?");
      $stmt->bind_param('ii', $user_id, $pid);
      $stmt->execute();
    } else {
      unset($_SESSION['cart'][$pid]);
    }
  }
  $_SESSION['toast-message'] = "Items Removed From Cart";
  $_SESSION['toast-icon'] = "error";
  header("Location: cart.php");
  exit();
}

ob_end_clean();
include('includes/header.php');
include('includes/navbar.php');
// cart();
?>
<script>
  document.title = 'Cart - Ecom Marketplace';
</script>

<main class="main">
  <div class="section-box">
    <div class="breadcrumbs-div">
      <div class="container">
        <ul class="breadcrumb">
          <li><a class="font-xs color-gray-1000" href="index.php">Home</a></li>
          <li><a class="font-xs color-gray-500" href="shop.php">Shop</a></li>
          <li><a class="font-xs color-gray-500" href="cart.php">Cart</a></li>
        </ul>
      </div>
    </div>
  </div>
  <section class="section-box shop-template">
    <div class="container">
      <div class="row">
        <div class="col-lg-9">
          <form class="box-carts" method="post">
            <div class="head-wishlist">
              <div class="item-wishlist">
                <div class="wishlist-cb">
                  <input class="cb-layout cb-all" type="checkbox" id="select-all">
                </div>
                <div class="wishlist-product"><span class="font-md-bold color-brand-3">Product</span></div>
                <div class="wishlist-price"><span class="font-md-bold color-brand-3">Unit Price</span></div>
                <div class="wishlist-status"><span class="font-md-bold color-brand-3">Quantity</span></div>
                <div class="wishlist-action"><span class="font-md-bold color-brand-3">Subtotal</span></div>
                <div class="wishlist-remove"><span class="font-md-bold color-brand-3">Remove</span></div>
              </div>
            </div>
            <div class="content-wishlist mb-20">
              <?php
              if (!empty($cartItems)) {

                foreach ($cartItems as $item) {
                  $product_id = $item['product_id'];
                  $product_title = $item['product_title'];
                  $subtotal = $item['product_price'] * $item['quantity'];
                  $product_quantity = $item['quantity'];
                  $product_price = $item['product_price'];
                  $product_image = $item['product_image_1'];


                  echo '<div class="item-wishlist">
                        <div class="wishlist-cb">
                          <input class="cb-layout cb-select" type="checkbox" name="remove[]" value="' . $product_id . '">
                        </div>
                        <div class="wishlist-product">
                          <div class="product-wishlist">
                            <div class="product-image">
                              <a href="product.php">
                                <img src="images/' . $product_image . '" alt="Ecom">
                              </a>
                            </div>
                            <div class="product-info"><a href="product.php">
                                <h6 class="color-brand-3">' . $product_title . '</h6>
                              </a>
                              <div class="rating">
                                <img src="images/star.svg" alt="Ecom">
                                <img src="images/star.svg" alt="Ecom">
                                <img src="images/star.svg" alt="Ecom">
                                <img src="images/star.svg" alt="Ecom">
                                <img src="images/star.svg" alt="Ecom">
                                <span class="font-xs color-gray-500"> (65)</span>
                              </div>
                            </div>
                          </div>
                        </div>
                        <div class="wishlist-price">
                          <h4 class="color-brand-3">$' . $product_price . '</h4>
                        </div>
                        <div class="wishlist-status">
                          <div class="box-quantity">
                            <div class="input-quantity">
                              <input class="font-xl color-brand-3" type="text" value="' . $product_quantity . '" min="1" name="qty[' . $product_id . ']">
                              <span class="minus-cart"></span>
                              <span class="plus-cart"></span>
                            </div>
                          </div>
                        </div>
                        <div class="wishlist-action">
                          <h4 class="color-brand-3">$' . $subtotal . '</h4>
                        </div>
                        <div class="wishlist-remove">
                          <a class="btn btn-delete" href="cart.php?deleteItem=' . $product_id . '"></a>
                        </div>
                      </div>';
                }
              } else {

              ?>
                <div class="container">
                  <div class="text-center mb-150 mt-50">
                    <div class="image-404 mb-50"> <img src="images/404.png" alt="Ecom"></div>
                    <h3>Your Cart Is Empty</h3>
                    <p class="font-md-bold color-gray-600">This Place is Abandoned</p>
                    <div class="mt-15"> <a class="btn btn-buy w-auto arrow-back" href="index.php">Back to Homepage</a></div>
                  </div>
                </div>
              <?php
              }
              ?>
            </div>
            <div class="row mb-40">
              <div class="col-lg-6 col-md-6 col-sm-6-col-6"><a class="btn btn-buy w-auto arrow-back mb-10"
                  href="shop.php">Continue shopping</a></div>
              <div class="col-lg-6 col-md-6 col-sm-6-col-6 text-md-end">
                <input class="btn btn-buy w-auto update-cart mb-10" type="submit" name="update-cart" value="Update cart">
                <input class="btn btn-buy w-auto mb-10" type="submit" name="remove-selected" value="Remove Selected">
              </div>
            </div>
            <div class="row mb-50">
              <div class="col-lg-6 col-md-6">
                <div class="box-cart-left">
                  <h5 class="font-md-bold mb-10">Calculate Shipping</h5><span
                    class="font-sm-bold mb-5 d-inline-block color-gray-500">Flat rate:</span><span
                    class="font-sm-bold d-inline-block color-brand-3">5%</span>
                  <div class="form-group">
                    <select class="form-control select-style1 color-gray-700">
                      <option value="1">USA</option>
                      <option value="1">EURO</option>
                    </select>
                  </div>
                  <div class="row">
                    <div class="col-lg-6 mb-10">
                      <input class="form-control" placeholder="Stage / Country">
                    </div>
                    <div class="col-lg-6 mb-10">
                      <input class="form-control" placeholder="PostCode / ZIP">
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-lg-6 col-md-6">
                <div class="box-cart-right p-20">
                  <h5 class="font-md-bold mb-10">Apply Coupon</h5><span
                    class="font-sm-bold mb-5 d-inline-block color-gray-500">Using A Promo Code?</span>
                  <div class="form-group d-flex">
                    <input class="form-control mr-15" placeholder="Enter Your Coupon">
                    <button class="btn btn-buy w-auto">Apply</button>
                  </div>
                </div>
              </div>
            </div>
          </form>
        </div>
        <div class="col-lg-3">
          <div class="summary-cart">
            <div class="border-bottom mb-10">
              <div class="row">
                <div class="col-6"><span class="font-md-bold color-gray-500">Subtotal</span></div>
                <div class="col-6 text-end">
                  <h4> $<?php total_price(); ?></h4>
                </div>
              </div>
            </div>
            <div class="border-bottom mb-10">
              <div class="row">
                <div class="col-6"><span class="font-md-bold color-gray-500">Shipping</span></div>
                <div class="col-6 text-end">
                  <h4> Free</h4>
                </div>
              </div>
            </div>
            <div class="border-bottom mb-10">
              <div class="row">
                <div class="col-6"><span class="font-md-bold color-gray-500">Estimate for</span></div>
                <div class="col-6 text-end">
                  <h6>United Kingdom</h6>
                </div>
              </div>
            </div>
            <div class="mb-10">
              <div class="row">
                <div class="col-6"><span class="font-md-bold color-gray-500">Total</span></div>
                <div class="col-6 text-end">
                  <h4> $<?php echo $totalPrice; ?></h4>
                </div>
              </div>
            </div>
            <div class="box-button">
              <?php if (isset($_SESSION['username'])) {
                echo '<a class="btn btn-buy" href="shop-checkout.html">Proceed To CheckOut</a>';
              } else {
                echo '<a class="btn btn-buy" href="shop-checkout.html">Login To CheckOut</a>';
              } ?>
            </div>
          </div>
        </div>
      </div>
      <h4 class="color-brand-3">You may also like</h4>
      <div class="list-products-5 mt-20 mb-40">
        <div class="card-grid-style-3">
          <div class="card-grid-inner">
            <div class="tools"><a class="btn btn-trend btn-tooltip mb-10" href="#" aria-label="Trend"
                data-bs-placement="left"></a><a class="btn btn-wishlist btn-tooltip mb-10" href="shop-wishlist.html"
                aria-label="Add To Wishlist"></a><a class="btn btn-compare btn-tooltip mb-10" href="shop-compare.html"
                aria-label="Compare"></a><a class="btn btn-quickview btn-tooltip" aria-label="Quick view"
                href="#ModalQuickview" data-bs-toggle="modal"></a></div>
            <div class="image-box"><span class="label bg-brand-2">-17%</span><a href="product.php"><img
                  src="images/imgsp3.png" alt="Ecom"></a></div>
            <div class="info-right"><a class="font-xs color-gray-500" href="shop-vendor-single.html">Hisense</a><br><a
                class="color-brand-3 font-sm-bold" href="product.php">Hisense 43" Class 4K UHD LED XClass
                Smart TV HDR</a>
              <div class="rating"><img src="images/star.svg" alt="Ecom"><img src="images/star.svg" alt="Ecom"><img
                  src="images/star.svg" alt="Ecom"><img src="images/star.svg" alt="Ecom"><img src="images/star.svg"
                  alt="Ecom"><span class="font-xs color-gray-500">(65)</span></div>
              <div class="price-info"><strong class="font-lg-bold color-brand-3 price-main">$2856.3</strong><span
                  class="color-gray-500 price-line">$3225.6</span></div>
              <div class="mt-20 box-btn-cart"><a class="btn btn-cart" href="cart.php">Add To Cart</a></div>
              <ul class="list-features">
                <li>27-inch (diagonal) Retina 5K display</li>
                <li>3.1GHz 6-core 10th-generation Intel Core i5</li>
                <li>AMD Radeon Pro 5300 graphics</li>
              </ul>
            </div>
          </div>
        </div>
        <div class="card-grid-style-3">
          <div class="card-grid-inner">
            <div class="tools"><a class="btn btn-trend btn-tooltip mb-10" href="#" aria-label="Trend"
                data-bs-placement="left"></a><a class="btn btn-wishlist btn-tooltip mb-10" href="shop-wishlist.html"
                aria-label="Add To Wishlist"></a><a class="btn btn-compare btn-tooltip mb-10" href="shop-compare.html"
                aria-label="Compare"></a><a class="btn btn-quickview btn-tooltip" aria-label="Quick view"
                href="#ModalQuickview" data-bs-toggle="modal"></a></div>
            <div class="image-box"><span class="label bg-brand-2">-17%</span><a href="product.php"><img
                  src="images/imgsp4.png" alt="Ecom"></a></div>
            <div class="info-right"><a class="font-xs color-gray-500" href="shop-vendor-single.html">Apple</a><br><a
                class="color-brand-3 font-sm-bold" href="product.php">2022 Apple 10.9-inch iPad Air Wi-Fi
                64GB - Silver</a>
              <div class="rating"><img src="images/star.svg" alt="Ecom"><img src="images/star.svg" alt="Ecom"><img
                  src="images/star.svg" alt="Ecom"><img src="images/star.svg" alt="Ecom"><img src="images/star.svg"
                  alt="Ecom"><span class="font-xs color-gray-500">(65)</span></div>
              <div class="price-info"><strong class="font-lg-bold color-brand-3 price-main">$2856.3</strong><span
                  class="color-gray-500 price-line">$3225.6</span></div>
              <div class="mt-20 box-btn-cart"><a class="btn btn-cart" href="cart.php">Add To Cart</a></div>
              <ul class="list-features">
                <li>27-inch (diagonal) Retina 5K display</li>
                <li>3.1GHz 6-core 10th-generation Intel Core i5</li>
                <li>AMD Radeon Pro 5300 graphics</li>
              </ul>
            </div>
          </div>
        </div>
        <div class="card-grid-style-3">
          <div class="card-grid-inner">
            <div class="tools"><a class="btn btn-trend btn-tooltip mb-10" href="#" aria-label="Trend"
                data-bs-placement="left"></a><a class="btn btn-wishlist btn-tooltip mb-10" href="shop-wishlist.html"
                aria-label="Add To Wishlist"></a><a class="btn btn-compare btn-tooltip mb-10" href="shop-compare.html"
                aria-label="Compare"></a><a class="btn btn-quickview btn-tooltip" aria-label="Quick view"
                href="#ModalQuickview" data-bs-toggle="modal"></a></div>
            <div class="image-box"><span class="label bg-brand-2">-17%</span><a href="product.php"><img
                  src="images/imgsp5.png" alt="Ecom"></a></div>
            <div class="info-right"><a class="font-xs color-gray-500" href="shop-vendor-single.html">LG</a><br><a
                class="color-brand-3 font-sm-bold" href="product.php">LG 65" Class 4K UHD Smart TV OLED
                A1 Series </a>
              <div class="rating"><img src="images/star.svg" alt="Ecom"><img src="images/star.svg" alt="Ecom"><img
                  src="images/star.svg" alt="Ecom"><img src="images/star.svg" alt="Ecom"><img src="images/star.svg"
                  alt="Ecom"><span class="font-xs color-gray-500">(65)</span></div>
              <div class="price-info"><strong class="font-lg-bold color-brand-3 price-main">$2856.3</strong><span
                  class="color-gray-500 price-line">$3225.6</span></div>
              <div class="mt-20 box-btn-cart"><a class="btn btn-cart" href="cart.php">Add To Cart</a></div>
              <ul class="list-features">
                <li>27-inch (diagonal) Retina 5K display</li>
                <li>3.1GHz 6-core 10th-generation Intel Core i5</li>
                <li>AMD Radeon Pro 5300 graphics</li>
              </ul>
            </div>
          </div>
        </div>
        <div class="card-grid-style-3">
          <div class="card-grid-inner">
            <div class="tools"><a class="btn btn-trend btn-tooltip mb-10" href="#" aria-label="Trend"
                data-bs-placement="left"></a><a class="btn btn-wishlist btn-tooltip mb-10" href="shop-wishlist.html"
                aria-label="Add To Wishlist"></a><a class="btn btn-compare btn-tooltip mb-10" href="shop-compare.html"
                aria-label="Compare"></a><a class="btn btn-quickview btn-tooltip" aria-label="Quick view"
                href="#ModalQuickview" data-bs-toggle="modal"></a></div>
            <div class="image-box"><span class="label bg-brand-2">-17%</span><a href="product.php"><img
                  src="images/imgsp6.png" alt="Ecom"></a></div>
            <div class="info-right"><a class="font-xs color-gray-500" href="shop-vendor-single.html">Apple</a><br><a
                class="color-brand-3 font-sm-bold" href="product.php">Apple AirPods Pro with MagSafe
                Charging Case</a>
              <div class="rating"><img src="images/star.svg" alt="Ecom"><img src="images/star.svg" alt="Ecom"><img
                  src="images/star.svg" alt="Ecom"><img src="images/star.svg" alt="Ecom"><img src="images/star.svg"
                  alt="Ecom"><span class="font-xs color-gray-500">(65)</span></div>
              <div class="price-info"><strong class="font-lg-bold color-brand-3 price-main">$2856.3</strong><span
                  class="color-gray-500 price-line">$3225.6</span></div>
              <div class="mt-20 box-btn-cart"><a class="btn btn-cart" href="cart.php">Add To Cart</a></div>
              <ul class="list-features">
                <li>27-inch (diagonal) Retina 5K display</li>
                <li>3.1GHz 6-core 10th-generation Intel Core i5</li>
                <li>AMD Radeon Pro 5300 graphics</li>
              </ul>
            </div>
          </div>
        </div>
        <div class="card-grid-style-3">
          <div class="card-grid-inner">
            <div class="tools"><a class="btn btn-trend btn-tooltip mb-10" href="#" aria-label="Trend"
                data-bs-placement="left"></a><a class="btn btn-wishlist btn-tooltip mb-10" href="shop-wishlist.html"
                aria-label="Add To Wishlist"></a><a class="btn btn-compare btn-tooltip mb-10" href="shop-compare.html"
                aria-label="Compare"></a><a class="btn btn-quickview btn-tooltip" aria-label="Quick view"
                href="#ModalQuickview" data-bs-toggle="modal"></a></div>
            <div class="image-box"><span class="label bg-brand-2">-17%</span><a href="product.php"><img
                  src="images/imgsp7.png" alt="Ecom"></a></div>
            <div class="info-right"><a class="font-xs color-gray-500" href="shop-vendor-single.html">Razer</a><br><a
                class="color-brand-3 font-sm-bold" href="product.php">Razer Power Up Gaming Bundle V2 -
                Cynosa Lite</a>
              <div class="rating"><img src="images/star.svg" alt="Ecom"><img src="images/star.svg" alt="Ecom"><img
                  src="images/star.svg" alt="Ecom"><img src="images/star.svg" alt="Ecom"><img src="images/star.svg"
                  alt="Ecom"><span class="font-xs color-gray-500">(65)</span></div>
              <div class="price-info"><strong class="font-lg-bold color-brand-3 price-main">$2856.3</strong><span
                  class="color-gray-500 price-line">$3225.6</span></div>
              <div class="mt-20 box-btn-cart"><a class="btn btn-cart" href="cart.php">Add To Cart</a></div>
              <ul class="list-features">
                <li>27-inch (diagonal) Retina 5K display</li>
                <li>3.1GHz 6-core 10th-generation Intel Core i5</li>
                <li>AMD Radeon Pro 5300 graphics</li>
              </ul>
            </div>
          </div>
        </div>
      </div>
      <h4 class="color-brand-3">Recently viewed items</h4>
      <div class="row mt-40">
        <div class="col-lg-3 col-md-6 col-sm-12">
          <div class="card-grid-style-2 card-grid-none-border hover-up">
            <div class="image-box"><a href="product.php"><img src="images/imgsp1.png" alt="Ecom"></a>
            </div>
            <div class="info-right"><span class="font-xs color-gray-500">HP</span><br><a
                class="color-brand-3 font-xs-bold" href="product.php">HP DeskJet 2755e Wireless Color
                All-in-One Printer</a>
              <div class="rating"><img src="images/star.svg" alt="Ecom"><img src="images/star.svg" alt="Ecom"><img
                  src="images/star.svg" alt="Ecom"><img src="images/star.svg" alt="Ecom"><img src="images/star.svg"
                  alt="Ecom"><span class="font-xs color-gray-500"> (65)</span></div>
              <div class="price-info"><strong class="font-lg-bold color-brand-3 price-main">$2556.3</strong><span
                  class="color-gray-500 price-line">$3225.6</span></div>
            </div>
          </div>
        </div>
        <div class="col-lg-3 col-md-6 col-sm-12">
          <div class="card-grid-style-2 card-grid-none-border hover-up">
            <div class="image-box"><a href="product.php"><img src="images/imgsp2.png" alt="Ecom"></a>
            </div>
            <div class="info-right"><span class="font-xs color-gray-500">HP</span><br><a
                class="color-brand-3 font-xs-bold" href="product.php">Original HP 63XL Black High-yield
                Ink Cartridge</a>
              <div class="rating"><img src="images/star.svg" alt="Ecom"><img src="images/star.svg" alt="Ecom"><img
                  src="images/star.svg" alt="Ecom"><img src="images/star.svg" alt="Ecom"><img src="images/star.svg"
                  alt="Ecom"><span class="font-xs color-gray-500"> (65)</span></div>
              <div class="price-info"><strong class="font-lg-bold color-brand-3 price-main">$2556.3</strong><span
                  class="color-gray-500 price-line">$3225.6</span></div>
            </div>
          </div>
        </div>
        <div class="col-lg-3 col-md-6 col-sm-12">
          <div class="card-grid-style-2 card-grid-none-border hover-up">
            <div class="image-box"><a href="product.php"><img src="images/imgsp1.png" alt="Ecom"></a>
            </div>
            <div class="info-right"><span class="font-xs color-gray-500">Logitech</span><br><a
                class="color-brand-3 font-xs-bold" href="product.php">Logitech H390 Wired Headset, Stereo
                Headphones</a>
              <div class="rating"><img src="images/star.svg" alt="Ecom"><img src="images/star.svg" alt="Ecom"><img
                  src="images/star.svg" alt="Ecom"><img src="images/star.svg" alt="Ecom"><img src="images/star.svg"
                  alt="Ecom"><span class="font-xs color-gray-500"> (65)</span></div>
              <div class="price-info"><strong class="font-lg-bold color-brand-3 price-main">$2556.3</strong><span
                  class="color-gray-500 price-line">$3225.6</span></div>
            </div>
          </div>
        </div>
        <div class="col-lg-3 col-md-6 col-sm-12">
          <div class="card-grid-style-2 card-grid-none-border hover-up">
            <div class="image-box"><a href="product.php"><img src="images/imgsp2.png" alt="Ecom"></a>
            </div>
            <div class="info-right"><span class="font-xs color-gray-500">Logitech</span><br><a
                class="color-brand-3 font-xs-bold" href="product.php">Logitech MK345 Wireless Combo
                Full-Sized</a>
              <div class="rating"><img src="images/star.svg" alt="Ecom"><img src="images/star.svg" alt="Ecom"><img
                  src="images/star.svg" alt="Ecom"><img src="images/star.svg" alt="Ecom"><img src="images/star.svg"
                  alt="Ecom"><span class="font-xs color-gray-500"> (65)</span></div>
              <div class="price-info"><strong class="font-lg-bold color-brand-3 price-main">$2556.3</strong><span
                  class="color-gray-500 price-line">$3225.6</span></div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
  <section class="section-box mt-90 mb-50">
    <div class="container">
      <ul class="list-col-5">
        <li>
          <div class="item-list">
            <div class="icon-left"><img src="images/delivery.svg" alt="Ecom"></div>
            <div class="info-right">
              <h5 class="font-lg-bold color-gray-100">Free Delivery</h5>
              <p class="font-sm color-gray-500">For orders over $70</p>
            </div>
          </div>
        </li>
        <li>
          <div class="item-list">
            <div class="icon-left"><img src="images/support.svg" alt="Ecom"></div>
            <div class="info-right">
              <h5 class="font-lg-bold color-gray-100">Support 24/7</h5>
              <p class="font-sm color-gray-500">Shop with an expert</p>
            </div>
          </div>
        </li>
        <li>
          <div class="item-list">
            <div class="icon-left"><img src="images/voucher.svg" alt="Ecom"></div>
            <div class="info-right">
              <h5 class="font-lg-bold color-gray-100">Gift voucher</h5>
              <p class="font-sm color-gray-500">Refer a friend</p>
            </div>
          </div>
        </li>
        <li>
          <div class="item-list">
            <div class="icon-left"><img src="images/return.svg" alt="Ecom"></div>
            <div class="info-right">
              <h5 class="font-lg-bold color-gray-100">Return & Refund</h5>
              <p class="font-sm color-gray-500">Return over $200</p>
            </div>
          </div>
        </li>
        <li>
          <div class="item-list">
            <div class="icon-left"><img src="images/secure.svg" alt="Ecom"></div>
            <div class="info-right">
              <h5 class="font-lg-bold color-gray-100">Secure payment</h5>
              <p class="font-sm color-gray-500">100% Protected</p>
            </div>
          </div>
        </li>
      </ul>
    </div>
  </section>
  <section class="section-box box-newsletter">
    <div class="container">
      <div class="row">
        <div class="col-lg-6 col-md-7 col-sm-12">
          <h3 class="color-white">Subscrible & Get <span class="color-warning">10%</span> Discount</h3>
          <p class="font-lg color-white">Get E-mail updates about our latest shop and <span
              class="font-lg-bold">special offers.</span></p>
        </div>
        <div class="col-lg-4 col-md-5 col-sm-12">
          <div class="box-form-newsletter mt-15">
            <form class="form-newsletter">
              <input class="input-newsletter font-xs" value="" placeholder="Your email Address">
              <button class="btn btn-brand-2">Sign Up</button>
            </form>
          </div>
        </div>
      </div>
    </div>
  </section>
  <div class="modal fade" id="ModalFiltersForm" tabindex="-1" aria-hidden="true" style="display: none;">
    <div class="modal-dialog modal-xl">
      <div class="modal-content apply-job-form">
        <div class="modal-header">
          <h5 class="modal-title color-gray-1000 filters-icon">Addvance Fillters</h5>
          <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body p-30">
          <div class="row">
            <div class="col-w-1">
              <h6 class="color-gray-900 mb-0">Brands</h6>
              <ul class="list-checkbox">
                <li>
                  <label class="cb-container">
                    <input type="checkbox" checked="checked"><span class="text-small">Apple</span><span
                      class="checkmark"></span>
                  </label>
                </li>
                <li>
                  <label class="cb-container">
                    <input type="checkbox"><span class="text-small">Samsung</span><span class="checkmark"></span>
                  </label>
                </li>
                <li>
                  <label class="cb-container">
                    <input type="checkbox"><span class="text-small">Baseus</span><span class="checkmark"></span>
                  </label>
                </li>
                <li>
                  <label class="cb-container">
                    <input type="checkbox"><span class="text-small">Remax</span><span class="checkmark"></span>
                  </label>
                </li>
                <li>
                  <label class="cb-container">
                    <input type="checkbox"><span class="text-small">Handtown</span><span class="checkmark"></span>
                  </label>
                </li>
                <li>
                  <label class="cb-container">
                    <input type="checkbox"><span class="text-small">Elecom</span><span class="checkmark"></span>
                  </label>
                </li>
                <li>
                  <label class="cb-container">
                    <input type="checkbox"><span class="text-small">Razer</span><span class="checkmark"></span>
                  </label>
                </li>
                <li>
                  <label class="cb-container">
                    <input type="checkbox"><span class="text-small">Auto Focus</span><span class="checkmark"></span>
                  </label>
                </li>
                <li>
                  <label class="cb-container">
                    <input type="checkbox"><span class="text-small">Nillkin</span><span class="checkmark"></span>
                  </label>
                </li>
                <li>
                  <label class="cb-container">
                    <input type="checkbox"><span class="text-small">Logitech</span><span class="checkmark"></span>
                  </label>
                </li>
                <li>
                  <label class="cb-container">
                    <input type="checkbox"><span class="text-small">ChromeBook</span><span class="checkmark"></span>
                  </label>
                </li>
              </ul>
            </div>
            <div class="col-w-1">
              <h6 class="color-gray-900 mb-0">Special offers</h6>
              <ul class="list-checkbox">
                <li>
                  <label class="cb-container">
                    <input type="checkbox"><span class="text-small">On sale</span><span class="checkmark"></span>
                  </label>
                </li>
                <li>
                  <label class="cb-container">
                    <input type="checkbox" checked="checked"><span class="text-small">FREE shipping</span><span
                      class="checkmark"></span>
                  </label>
                </li>
                <li>
                  <label class="cb-container">
                    <input type="checkbox"><span class="text-small">Big deals</span><span class="checkmark"></span>
                  </label>
                </li>
                <li>
                  <label class="cb-container">
                    <input type="checkbox"><span class="text-small">Shop Mall</span><span class="checkmark"></span>
                  </label>
                </li>
              </ul>
              <h6 class="color-gray-900 mb-0 mt-40">Ready to ship in</h6>
              <ul class="list-checkbox">
                <li>
                  <label class="cb-container">
                    <input type="checkbox"><span class="text-small">1 business day</span><span
                      class="checkmark"></span>
                  </label>
                </li>
                <li>
                  <label class="cb-container">
                    <input type="checkbox" checked="checked"><span class="text-small">1–3 business days</span><span
                      class="checkmark"></span>
                  </label>
                </li>
                <li>
                  <label class="cb-container">
                    <input type="checkbox"><span class="text-small">in 1 week</span><span class="checkmark"></span>
                  </label>
                </li>
                <li>
                  <label class="cb-container">
                    <input type="checkbox"><span class="text-small">Shipping now</span><span class="checkmark"></span>
                  </label>
                </li>
              </ul>
            </div>
            <div class="col-w-1">
              <h6 class="color-gray-900 mb-0">Ordering options</h6>
              <ul class="list-checkbox">
                <li>
                  <label class="cb-container">
                    <input type="checkbox"><span class="text-small">Accepts gift cards</span><span
                      class="checkmark"></span>
                  </label>
                </li>
                <li>
                  <label class="cb-container">
                    <input type="checkbox"><span class="text-small">Customizable</span><span class="checkmark"></span>
                  </label>
                </li>
                <li>
                  <label class="cb-container">
                    <input type="checkbox" checked="checked"><span class="text-small">Can be gift-wrapped</span><span
                      class="checkmark"></span>
                  </label>
                </li>
                <li>
                  <label class="cb-container">
                    <input type="checkbox"><span class="text-small">Installment 0%</span><span
                      class="checkmark"></span>
                  </label>
                </li>
              </ul>
              <h6 class="color-gray-900 mb-0 mt-40">Rating</h6>
              <ul class="list-checkbox">
                <li class="mb-5"><a href="#"><img src="images/star.svg" alt="Ecom"><img src="images/star.svg"
                      alt="Ecom"><img src="images/star.svg" alt="Ecom"><img src="images/star.svg" alt="Ecom"><img
                      src="images/star.svg" alt="Ecom"><span
                      class="ml-10 font-xs color-gray-500 d-inline-block align-top">(5 stars)</span></a></li>
                <li class="mb-5"><a href="#"><img src="images/star.svg" alt="Ecom"><img src="images/star.svg"
                      alt="Ecom"><img src="images/star.svg" alt="Ecom"><img src="images/star.svg" alt="Ecom"><img
                      src="images/star-gray.svg" alt="Ecom"><span
                      class="ml-10 font-xs color-gray-500 d-inline-block align-top">(4 stars)</span></a></li>
                <li class="mb-5"><a href="#"><img src="images/star.svg" alt="Ecom"><img src="images/star.svg"
                      alt="Ecom"><img src="images/star.svg" alt="Ecom"><img src="images/star-gray.svg" alt="Ecom"><img
                      src="images/star-gray.svg" alt="Ecom"><span
                      class="ml-10 font-xs color-gray-500 d-inline-block align-top">(3 stars)</span></a></li>
                <li class="mb-5"><a href="#"><img src="images/star.svg" alt="Ecom"><img src="images/star.svg"
                      alt="Ecom"><img src="images/star-gray.svg" alt="Ecom"><img src="images/star-gray.svg"
                      alt="Ecom"><img src="images/star-gray.svg" alt="Ecom"><span
                      class="ml-10 font-xs color-gray-500 d-inline-block align-top">(2 stars)</span></a></li>
                <li class="mb-5"><a href="#"><img src="images/star.svg" alt="Ecom"><img src="images/star-gray.svg"
                      alt="Ecom"><img src="images/star-gray.svg" alt="Ecom"><img src="images/star-gray.svg"
                      alt="Ecom"><img src="images/star-gray.svg" alt="Ecom"><span
                      class="ml-10 font-xs color-gray-500 d-inline-block align-top">(1 star)</span></a></li>
              </ul>
            </div>
            <div class="col-w-2">
              <h6 class="color-gray-900 mb-0">Material</h6>
              <ul class="list-checkbox">
                <li>
                  <label class="cb-container">
                    <input type="checkbox"><span class="text-small">Nylon (8)</span><span class="checkmark"></span>
                  </label>
                </li>
                <li>
                  <label class="cb-container">
                    <input type="checkbox"><span class="text-small">Tempered Glass (5)</span><span
                      class="checkmark"></span>
                  </label>
                </li>
                <li>
                  <label class="cb-container">
                    <input type="checkbox" checked="checked"><span class="text-small">Liquid Silicone Rubber
                      (5)</span><span class="checkmark"></span>
                  </label>
                </li>
                <li>
                  <label class="cb-container">
                    <input type="checkbox"><span class="text-small">Aluminium Alloy (3)</span><span
                      class="checkmark"></span>
                  </label>
                </li>
              </ul>
              <h6 class="color-gray-900 mb-20 mt-40">Product tags</h6>
              <div><a class="btn btn-border mr-5" href="#">Games</a><a class="btn btn-border mr-5"
                  href="#">Electronics</a><a class="btn btn-border mr-5" href="#">Video</a><a
                  class="btn btn-border mr-5" href="#">Cellphone</a><a class="btn btn-border mr-5"
                  href="#">Indoor</a><a class="btn btn-border mr-5" href="#">VGA Card</a><a
                  class="btn btn-border mr-5" href="#">USB</a><a class="btn btn-border mr-5" href="#">Lightning</a><a
                  class="btn btn-border mr-5" href="#">Camera</a></div>
            </div>
          </div>
        </div>
        <div class="modal-footer justify-content-start pl-30"><a class="btn btn-buy w-auto" href="#">Apply
            Fillter</a><a class="btn font-sm-bold color-gray-500" href="#">Reset Fillter</a></div>
      </div>
    </div>
  </div>
  <div class="modal fade" id="ModalQuickview" tabindex="-1" aria-hidden="true" style="display: none;">
    <div class="modal-dialog modal-xl">
      <div class="modal-content apply-job-form">
        <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
        <div class="modal-body p-30">
          <div class="row">
            <div class="col-lg-6">
              <div class="gallery-image">
                <div class="galleries-2">
                  <div class="detail-gallery">
                    <div class="product-image-slider-2">
                      <figure class="border-radius-10"><img src="images/img-gallery-1.jpg" alt="product image">
                      </figure>
                      <figure class="border-radius-10"><img src="images/img-gallery-2.jpg" alt="product image">
                      </figure>
                      <figure class="border-radius-10"><img src="images/img-gallery-3.jpg" alt="product image">
                      </figure>
                      <figure class="border-radius-10"><img src="images/img-gallery-4.jpg" alt="product image">
                      </figure>
                      <figure class="border-radius-10"><img src="images/img-gallery-5.jpg" alt="product image">
                      </figure>
                      <figure class="border-radius-10"><img src="images/img-gallery-6.jpg" alt="product image">
                      </figure>
                      <figure class="border-radius-10"><img src="images/img-gallery-7.jpg" alt="product image">
                      </figure>
                    </div>
                  </div>
                  <div class="slider-nav-thumbnails-2">
                    <div>
                      <div class="item-thumb"><img src="images/img-gallery-1.jpg" alt="product image"></div>
                    </div>
                    <div>
                      <div class="item-thumb"><img src="images/img-gallery-2.jpg" alt="product image"></div>
                    </div>
                    <div>
                      <div class="item-thumb"><img src="images/img-gallery-3.jpg" alt="product image"></div>
                    </div>
                    <div>
                      <div class="item-thumb"><img src="images/img-gallery-4.jpg" alt="product image"></div>
                    </div>
                    <div>
                      <div class="item-thumb"><img src="images/img-gallery-5.jpg" alt="product image"></div>
                    </div>
                    <div>
                      <div class="item-thumb"><img src="images/img-gallery-6.jpg" alt="product image"></div>
                    </div>
                    <div>
                      <div class="item-thumb"><img src="images/img-gallery-7.jpg" alt="product image"></div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="box-tags">
                <div class="d-inline-block mr-25"><span class="font-sm font-medium color-gray-900">Category:</span><a
                    class="link" href="#">Smartphones</a></div>
                <div class="d-inline-block"><span class="font-sm font-medium color-gray-900">Tags:</span><a
                    class="link" href="#">Blue</a>,<a class="link" href="#">Smartphone</a></div>
              </div>
            </div>
            <div class="col-lg-6">
              <div class="product-info">
                <h5 class="mb-15">SAMSUNG Galaxy S22 Ultra, 8K Camera & Video, Brightest Display Screen, S Pen Pro
                </h5>
                <div class="info-by"><span class="bytext color-gray-500 font-xs font-medium">by</span><a
                    class="byAUthor color-gray-900 font-xs font-medium" href="shop-vendor-list.html"> Ecom Tech</a>
                  <div class="rating d-inline-block"><img src="images/star.svg" alt="Ecom"><img src="images/star.svg"
                      alt="Ecom"><img src="images/star.svg" alt="Ecom"><img src="images/star.svg" alt="Ecom"><img
                      src="images/star.svg" alt="Ecom"><span class="font-xs color-gray-500 font-medium"> (65
                      reviews)</span></div>
                </div>
                <div class="border-bottom pt-10 mb-20"></div>
                <div class="box-product-price">
                  <h3 class="color-brand-3 price-main d-inline-block mr-10">$2856.3</h3><span
                    class="color-gray-500 price-line font-xl line-througt">$3225.6</span>
                </div>
                <div class="product-description mt-10 color-gray-900">
                  <ul class="list-dot">
                    <li>8k super steady video</li>
                    <li>Nightography plus portait mode</li>
                    <li>50mp photo resolution plus bright display</li>
                    <li>Adaptive color contrast</li>
                    <li>premium design & craftmanship</li>
                    <li>Long lasting battery plus fast charging</li>
                  </ul>
                </div>
                <div class="box-product-color mt-10">
                  <p class="font-sm color-gray-900">Color:<span class="color-brand-2 nameColor">Pink Gold</span></p>
                  <ul class="list-colors">
                    <li class="disabled"><img src="images/img-gallery-1.jpg" alt="Ecom" title="Pink"></li>
                    <li><img src="images/img-gallery-2.jpg" alt="Ecom" title="Gold"></li>
                    <li><img src="images/img-gallery-3.jpg" alt="Ecom" title="Pink Gold"></li>
                    <li><img src="images/img-gallery-4.jpg" alt="Ecom" title="Silver"></li>
                    <li class="active"><img src="images/img-gallery-5.jpg" alt="Ecom" title="Pink Gold"></li>
                    <li class="disabled"><img src="images/img-gallery-6.jpg" alt="Ecom" title="Black"></li>
                    <li class="disabled"><img src="images/img-gallery-7.jpg" alt="Ecom" title="Red"></li>
                  </ul>
                </div>
                <div class="box-product-style-size mt-10">
                  <div class="row">
                    <div class="col-lg-12 mb-10">
                      <p class="font-sm color-gray-900">Style:<span class="color-brand-2 nameStyle">S22</span></p>
                      <ul class="list-styles">
                        <li class="disabled" title="S22 Ultra">S22 Ultra</li>
                        <li class="active" title="S22">S22</li>
                        <li title="S22 + Standing Cover">S22 + Standing Cover</li>
                      </ul>
                    </div>
                    <div class="col-lg-12 mb-10">
                      <p class="font-sm color-gray-900">Size:<span class="color-brand-2 nameSize">512GB</span></p>
                      <ul class="list-sizes">
                        <li class="disabled" title="1GB">1GB</li>
                        <li class="active" title="512 GB">512 GB</li>
                        <li title="256 GB">256 GB</li>
                        <li title="128 GB">128 GB</li>
                        <li class="disabled" title="64GB">64GB</li>
                      </ul>
                    </div>
                  </div>
                </div>
                <div class="buy-product mt-5">
                  <p class="font-sm mb-10">Quantity</p>
                  <div class="box-quantity">
                    <div class="input-quantity">
                      <input class="font-xl color-brand-3" type="text" value="1"><span class="minus-cart"></span><span
                        class="plus-cart"></span>
                    </div>
                    <div class="button-buy"><a class="btn btn-cart" href="cart.php">Add to cart</a><a
                        class="btn btn-buy" href="shop-checkout.html">Buy now</a></div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</main>
<script>
  document.addEventListener('DOMContentLoaded', function() {
    const selectAllCheckbox = document.getElementById('select-all');
    const itemCheckboxes = document.querySelectorAll('.cb-select');

    if (selectAllCheckbox) {
      selectAllCheckbox.addEventListener('change', function() {
        // Loop through all individual checkboxes and match their checked state
        itemCheckboxes.forEach(checkbox => {
          checkbox.checked = selectAllCheckbox.checked;
        });
      });

      // If a user manually unchecks one item, 
      // uncheck the master "Select All" checkbox automatically.
      itemCheckboxes.forEach(checkbox => {
        checkbox.addEventListener('change', function() {
          // If any checkbox is unchecked, "Select All" becomes false
          if (!this.checked) {
            selectAllCheckbox.checked = false;
          } else {
            // If ALL individual checkboxes are checked, turn "Select All" back on
            const allChecked = Array.from(itemCheckboxes).every(cb => cb.checked);
            selectAllCheckbox.checked = allChecked;
          }
        });
      });
    }
  });
</script>
<?php include('includes/footer-nav.php'); ?>
<?php include('includes/bottom.php'); ?>

</body>

</html>