<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once('includes/dbconnect.php');
require_once('includes/config.php');
require_once('includes/common_functions.php');

// Include Safepay SDK core classes
require_once('safepay/src/Base.php');
require_once('safepay/src/Lib/Requestor.php');
require_once('safepay/src/Checkout.php');
require_once('safepay/src/Payments.php');
require_once('safepay/src/Verify.php');
require_once('safepay/src/Safepay.php');

use Safepay\Safepay;

if (!isset($_SESSION['username'])) {
    echo "<script>alert('Please Login first!');window.location.href='login.php'</script>";
    exit();
}

$username = $_SESSION['username'];
$stmt = $con->prepare('SELECT `user_id`, `user_full_name`, `user_email`, `user_phone_1`, `user_address` FROM `ecom_users` WHERE `user_username`=?');
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

// Fetch item arrays from your project database cart tables
$stmt_cart = $con->prepare('SELECT c.product_id, p.product_title, p.product_price, c.quantity FROM ecom_cart_details c JOIN ecom_products p ON c.product_id = p.product_id WHERE c.user_id=?');
$stmt_cart->bind_param('i', $user_id);
$stmt_cart->execute();
$result_cart = $stmt_cart->get_result();

if ($result_cart->num_rows == 0) {
    echo "<script>alert('Your Cart is Empty!');window.location.href='cart.php'</script>";
    exit();
}

while ($row = $result_cart->fetch_assoc()) {
    $subtotal = $row['product_price'] * $row['quantity'];
    $total_price += $subtotal;
    $cart_items[] = $row;
}

// Safepay processes currency subunits (multiply your PKR total by 100)
$amount_in_paise = $total_price * 100;

if (isset($_POST['place_safepay_order'])) {
    $config = [
        "environment"   => 'sandbox',
        "apiKey"        => 'sec_1c973793-3e8e-4558-91a2-bce5818583f8',
        "v1Secret"      => '81f4d8dc5f14356cf11d4daa05f9f3eb71cffd7f1cd993abce9c08e237385b52',
        "webhookSecret" => '387fd4e0856d281e407d03242697221fca08f97faf2d007a64d61fe99d5a2f9d'
    ];

    $safepay = new Safepay($config);
    $unique_order_reference = "ORD_" . time() . "_" . $user_id;

    try {
        $token_url = "https://sandbox.api.getsafepay.com/order/v1/init";

        $payload = [
            'client'      => 'sec_1c973793-3e8e-4558-91a2-bce5818583f8', 
            'environment' => 'sandbox',
            'amount'      => (int)$amount_in_paise,
            'currency'    => 'PKR'
        ];

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $token_url);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($payload));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($ch, CURLOPT_RESOLVE, ["sandbox.api.getsafepay.com:443:104.21.50.210"]);

        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Content-Type: application/json',
            'Accept: application/json'
        ]);

        $server_output = curl_exec($ch);
        curl_close($ch);

        $response = json_decode($server_output, true);

        $paymentToken = '';
        if (isset($response['data']['token'])) {
            $paymentToken = $response['data']['token'];
        } elseif (isset($response['token'])) {
            $paymentToken = $response['token'];
        } else {
            throw new Exception("Gateway initialization rejected.");
        }

        $checkout_data = $safepay->checkout->create([
            "token"       => $paymentToken,
            "order_id"    => "ORDER_" . time(),
            "source"      => "custom",
            "webhooks"    => "true",
            "success_url" => "http://localhost/ecom-market/success.php",
            "cancel_url"  => "http://localhost/ecom-market/checkout.php"
        ]);

        if (isset($checkout_data['result']) && $checkout_data['result'] === 'success') {
            $redirectUrl = $checkout_data['redirect'];
        } else {
            throw new Exception("Failed to generate secure checkout link.");
        }

        if (!headers_sent()) {
            header('Location: ' . $redirectUrl);
            exit();
        } else {
            echo "<script type='text/javascript'>window.top.location.href='" . $redirectUrl . "';</script>";
            exit();
        }
    } catch (Exception $e) {
        echo "<div style='color:red; background:#fff2f2; padding:15px; border:1px solid red; margin:20px;'>";
        echo "<strong>Gateway Initialization Blocked:</strong> " . htmlspecialchars($e->getMessage());
        echo "</div>";
    }
}
?>

<form method="POST" action="">
    <div class="container">
        <div class="row">
            <div class="col-lg-6">
                <div class="box-border">
                    <h5 class="font-md-bold color-brand-3 mb-20">Shipping & Delivery Details</h5>
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="form-group">
                                <input class="form-control font-sm" type="text" value="<?php echo htmlspecialchars($user['user_full_name']); ?>" placeholder="Full Name*" required>
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="form-group">
                                <input class="form-control font-sm" type="email" value="<?php echo htmlspecialchars($user['user_email']); ?>" placeholder="Email Address*" required>
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="form-group">
                                <input class="form-control font-sm" type="text" value="<?php echo htmlspecialchars($user['user_address']); ?>" placeholder="Delivery Address*" required>
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="form-group">
                                <input class="form-control font-sm" type="text" value="<?php echo htmlspecialchars($user['user_phone_1']); ?>" placeholder="Phone Number*" required>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row mt-20">
                    <div class="col-lg-6 col-5 mb-20">
                        <a class="btn font-sm-bold color-brand-1 arrow-back-1" href="cart.php">Return to Cart</a>
                    </div>
                    <div class="col-lg-6 col-7 mb-20 text-end">
                        <button type="submit" name="place_safepay_order" class="btn btn-buy w-auto arrow-next" style="border:none;">Confirm & Pay via Safepay</button>
                    </div>
                </div>
            </div>

            <div class="col-lg-6">
                <div class="box-border">
                    <h5 class="font-md-bold mb-20">Your Order Review</h5>
                    <div class="listCheckout">
                        <?php foreach ($cart_items as $item): ?>
                            <div class="item-wishlist">
                                <div class="wishlist-product">
                                    <div class="product-info" style="padding-left:0;">
                                        <h6 class="color-brand-3"><?php echo htmlspecialchars($item['product_title']); ?></h6>
                                    </div>
                                </div>
                                <div class="wishlist-status">
                                    <h5 class="color-gray-500">x<?php echo $item['quantity']; ?></h5>
                                </div>
                                <div class="wishlist-price">
                                    <h4 class="color-brand-3 font-lg-bold">Rs. <?php echo number_format($item['product_price'], 2); ?></h4>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>

                    <div class="form-group mb-0 mt-30">
                        <div class="row mb-10">
                            <div class="col-lg-6 col-6"><span class="font-md-bold color-brand-3">Subtotal</span></div>
                            <div class="col-lg-6 col-6 text-end"><span class="font-lg-bold color-brand-3">Rs. <?php echo number_format($total_price, 2); ?></span></div>
                        </div>
                        <div class="border-bottom mb-10 pb-5">
                            <div class="row">
                                <div class="col-lg-6 col-6"><span class="font-md-bold color-brand-3">Shipping</span></div>
                                <div class="col-lg-6 col-6 text-end"><span class="font-lg-bold color-brand-2">FREE</span></div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-6 col-6"><span class="font-md-bold color-brand-3">Total Payable (PKR)</span></div>
                            <div class="col-lg-6 col-6 text-end"><span class="font-lg-bold color-brand-3">Rs. <?php echo number_format($total_price, 2); ?></span></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>