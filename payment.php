<?php
require_once('includes/dbconnect.php');
require_once('includes/config.php');
require_once('includes/common_functions.php');

require_once('safepay/src/Base.php');
require_once('safepay/src/Checkout.php');
require_once('safepay/src/Payments.php');
require_once('safepay/src/Safepay.php');

use Safepay\Safepay;

if (!isset($_SESSION['username'])) {
    echo "<script>alert('Please Login first!');window.location.href='login.php'</script>";
    exit();
}
$username = $_SESSION['username'];
$stmt = $con->prepare('SELECT `user_id`, `user_username`, `user_full_name`, `user_email`, `user_password`, `user_phone_1`, `user_phone_2`, `user_address`, `user_created` FROM `ecom_users` WHERE `user_username`=?');
$stmt->bind_param('s', $username);
$stmt->execute();
$user = $stmt->get_result()->fetch_assoc();

if (!$user) {
    echo "<script>alert('User Not Found Please login!');window.location.href='login.php'</script>";
    exit();
}

$user_id = $user['user_id'];
$total_price = 0;
$cart_items = [];

$stmt_cart = $con->prepare('SELECT c.product_id, p.product_title, p.product_price, c.quantity FROM ecom_cart_details c JOIN ecom_products p ON c.product_id = p.product_id WHERE c.user_id=?');
$stmt_cart->bind_param('i', $user_id);
$stmt_cart->execute();
$result_cart = $stmt_cart->get_result();

if ($result_cart->num_rows == 0) {
    echo "<script>alert('Your Cart is Empty!');window.location.href='cart.php'</script>";
    exit();
}

while ($row = $result_cart->fetch_assoc()) {
    $row['subtotal'] = $row['product_price'] * $row['quantity'];
    $total_price += $row['subtotal'];
    $cart_items[] = $row;
}

$amount_in_paise = $total_price * 100;

$config = [
    "environment" => 'sandbox',
    "apiKey" => 'sec_e9273e07a7ac',
    "v1Secret" =>  'a73e5dad7cd8b1e7fea2f6d93f4c8',
    "webhookSecret" =>  '14509fdd8591a60427e'
];

$safepay = new Safepay($config);

// Create order

try {
    // 4. Generate a payment token for your order (e.g., 1000 PKR)
    $response = $safepay->payments->getToken([
        'receipt' => 'order_receipt_id' . uniqid(),
        'amount'   => $amount_in_paise,
        'currency' => 'PKR'
    ]);

    $paymentToken = $response['token'];

    // 5. Generate the checkout link
    $link = $safepay->checkout->create([
        "token"       => $paymentToken,
        "order_id"    => "ORDER_12345",
        "source"      => "custom",
        "webhooks"    => "true",
        "success_url" => "http://localhost/your-project/success.php",
        "cancel_url"  => "http://localhost/your-project/cancel.php"
    ]);

    // 6. Redirect your user directly to the payment screen
    if ($link['result'] === 'success') {
        header('Location: ' . $link['redirect']);
        exit();
    }
} catch (Exception $e) {
    echo "Payment initialization failed: " . $e->getMessage();
    exit();
}


?>
<div class="container">
    <div class="row">
        <div class="col-lg-6">
            <div class="box-border">
                <div class="box-payment"><a class="btn btn-gpay"><img src="images/gpay.svg" alt="Ecom"></a><a
                        class="btn btn-paypal"><img src="images/paypal.svg" alt="Ecom"></a><a class="btn btn-amazon"><img
                            src="images/amazon.svg" alt="Ecom"></a></div>
                <div class="border-bottom-4 text-center mb-20">
                    <div class="text-or font-md color-gray-500">Or</div>
                </div>
                <div class="row">
                    <div class="col-lg-6 col-sm-6 mb-20">
                        <h5 class="font-md-bold color-brand-3 text-sm-start text-center">Contact information</h5>
                    </div>
                    <div class="col-lg-6 col-sm-6 mb-20 text-sm-end text-center"><span class="font-sm color-brand-3">Already
                            have an account?</span><a class="font-sm color-brand-1" href="login.php"> Login</a></div>
                    <div class="col-lg-12">
                        <div class="form-group">
                            <input class="form-control font-sm" type="text" placeholder="Email*">
                        </div>
                    </div>
                    <div class="col-lg-12">
                        <div class="form-group">
                            <label class="font-sm color-brand-3" for="checkboxOffers">
                                <input class="checkboxOffer" id="checkboxOffers" type="checkbox">Keep me up to date on news and
                                exclusive offers
                            </label>
                        </div>
                    </div>
                    <div class="col-lg-12">
                        <h5 class="font-md-bold color-brand-3 mt-15 mb-20">Shipping address</h5>
                    </div>
                    <div class="col-lg-6">
                        <div class="form-group">
                            <input class="form-control font-sm" type="text" placeholder="First name*">
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="form-group">
                            <input class="form-control font-sm" type="text" placeholder="Last name*">
                        </div>
                    </div>
                    <div class="col-lg-12">
                        <div class="form-group">
                            <input class="form-control font-sm" type="text" placeholder="Address 1*">
                        </div>
                    </div>
                    <div class="col-lg-12">
                        <div class="form-group">
                            <input class="form-control font-sm" type="text" placeholder="Address 2*">
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="form-group">
                            <select class="form-control font-sm select-style1 color-gray-700">
                                <option value="">Select an option...</option>
                                <option value="1">Option 1</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="form-group">
                            <input class="form-control font-sm" type="text" placeholder="City*">
                        </div>
                    </div>
                    <div class="col-lg-12">
                        <div class="form-group">
                            <input class="form-control font-sm" type="text" placeholder="PostCode / ZIP*">
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="form-group">
                            <input class="form-control font-sm" type="text" placeholder="Company name">
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="form-group">
                            <input class="form-control font-sm" type="text" placeholder="Phone*">
                        </div>
                    </div>
                    <div class="col-lg-12">
                        <div class="form-group mb-0">
                            <textarea class="form-control font-sm" placeholder="Additional Information" rows="5"></textarea>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row mt-20">
                <div class="col-lg-6 col-5 mb-20"><a class="btn font-sm-bold color-brand-1 arrow-back-1"
                        href="cart.php">Return to Cart</a></div>
                <div class="col-lg-6 col-7 mb-20 text-end"><a class="btn btn-buy w-auto arrow-next"
                        href="checkout.php">Place an Order</a></div>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="box-border">
                <h5 class="font-md-bold mb-20">Your Order</h5>
                <div class="listCheckout">
                    <div class="item-wishlist">
                        <div class="wishlist-product">
                            <div class="product-wishlist">
                                <div class="product-image"><a href="product.php"><img src="images/img-sub.png"
                                            alt="Ecom"></a></div>
                                <div class="product-info"><a href="product.php">
                                        <h6 class="color-brand-3">Gateway 23.8" All-in-one Desktop, Fully Adjustable Stand</h6>
                                    </a>
                                    <div class="rating"><img src="images/star.svg" alt="Ecom"><img src="images/star.svg"
                                            alt="Ecom"><img src="images/star.svg" alt="Ecom"><img src="images/star.svg" alt="Ecom"><img
                                            src="images/star.svg" alt="Ecom"><span class="font-xs color-gray-500"> (65)</span></div>
                                </div>
                            </div>
                        </div>
                        <div class="wishlist-status">
                            <h5 class="color-gray-500">x1</h5>
                        </div>
                        <div class="wishlist-price">
                            <h4 class="color-brand-3 font-lg-bold">$2.51</h4>
                        </div>
                    </div>
                    <div class="item-wishlist">
                        <div class="wishlist-product">
                            <div class="product-wishlist">
                                <div class="product-image"><a href="product.php"><img src="images/img-sub2.png"
                                            alt="Ecom"></a></div>
                                <div class="product-info"><a href="product.php">
                                        <h6 class="color-brand-3">HP 24 All-in-One PC, Intel Core i3-1115G4, 4GB RAM</h6>
                                    </a>
                                    <div class="rating"><img src="images/star.svg" alt="Ecom"><img src="images/star.svg"
                                            alt="Ecom"><img src="images/star.svg" alt="Ecom"><img src="images/star.svg" alt="Ecom"><img
                                            src="images/star.svg" alt="Ecom"><span class="font-xs color-gray-500"> (65)</span></div>
                                </div>
                            </div>
                        </div>
                        <div class="wishlist-status">
                            <h5 class="color-gray-500">x1</h5>
                        </div>
                        <div class="wishlist-price">
                            <h4 class="color-brand-3 font-lg-bold">$1.51</h4>
                        </div>
                    </div>
                    <div class="item-wishlist">
                        <div class="wishlist-product">
                            <div class="product-wishlist">
                                <div class="product-image"><a href="product.php"><img src="images/img-sub3.png"
                                            alt="Ecom"></a></div>
                                <div class="product-info"><a href="product.php">
                                        <h6 class="color-brand-3">Dell Optiplex 9020 Small Form Business Desktop Tower PC</h6>
                                    </a>
                                    <div class="rating"><img src="images/star.svg" alt="Ecom"><img src="images/star.svg"
                                            alt="Ecom"><img src="images/star.svg" alt="Ecom"><img src="images/star.svg" alt="Ecom"><img
                                            src="images/star.svg" alt="Ecom"><span class="font-xs color-gray-500"> (65)</span></div>
                                </div>
                            </div>
                        </div>
                        <div class="wishlist-status">
                            <h5 class="color-gray-500">x1</h5>
                        </div>
                        <div class="wishlist-price">
                            <h4 class="color-brand-3 font-lg-bold">$3.51</h4>
                        </div>
                    </div>
                </div>
                <div class="form-group d-flex mt-15">
                    <input class="form-control mr-15" placeholder="Enter Your Coupon">
                    <button class="btn btn-buy w-auto">Apply</button>
                </div>
                <div class="form-group mb-0">
                    <div class="row mb-10">
                        <div class="col-lg-6 col-6"><span class="font-md-bold color-brand-3">Subtotal</span></div>
                        <div class="col-lg-6 col-6 text-end"><span class="font-lg-bold color-brand-3">$6.51</span></div>
                    </div>
                    <div class="border-bottom mb-10 pb-5">
                        <div class="row">
                            <div class="col-lg-6 col-6"><span class="font-md-bold color-brand-3">Shipping</span></div>
                            <div class="col-lg-6 col-6 text-end"><span class="font-lg-bold color-brand-3">-</span></div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-6 col-6"><span class="font-md-bold color-brand-3">Total</span></div>
                        <div class="col-lg-6 col-6 text-end"><span class="font-lg-bold color-brand-3">$6.51</span></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>