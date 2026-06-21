<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once('includes/dbconnect.php');

// 1. Ensure the user is logged in
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

$username = $_SESSION['username'];

// 2. Capture the parameters that Safepay just sent to the URL
$order_id = isset($_GET['order_id']) ? $_GET['order_id'] : '';
$tracker  = isset($_GET['tracker']) ? $_GET['tracker'] : '';

if (empty($tracker)) {
    echo "<h3>Invalid Access: Missing payment tracking information.</h3>";
    exit();
}

// --- REPLACE STEP 3 INSIDE YOUR success.php WITH THIS COMPLETELY ---

// 3. SECURE VERIFICATION: Call Safepay's Tracker Endpoint to verify the payment with authorization
$verify_url = "https://sandbox.api.getsafepay.com/order/v1/tracker/" . $tracker;

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $verify_url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
curl_setopt($ch, CURLOPT_RESOLVE, ["sandbox.api.getsafepay.com:443:104.21.50.210"]); // Keep your DNS bypass

// CRITICAL REWRITE: Authenticate the server request using your merchant secret
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    'Content-Type: application/json',
    'Accept: application/json',
    'X-SFPY-MERCHANT-SECRET: 81f4d8dc5f14356cf11d4daa05f9f3eb71cffd7f1cd993abce9c08e237385b52'
]);

$server_output = curl_exec($ch);
curl_close($ch);

$response = json_decode($server_output, true);

// Check if the transaction state or status is marked as successfully completed
$is_paid = false;

if (isset($response['data']['status']) && $response['data']['status'] === 'completed') {
    $is_paid = true;
} elseif (isset($response['status']) && $response['status'] === 'completed') {
    $is_paid = true;
} elseif (isset($response['data']['state']) && $response['data']['state'] === 'TRACKER_ENDED') {
    $is_paid = true;
} elseif (isset($response['state']) && $response['state'] === 'TRACKER_ENDED') {
    $is_paid = true;
}


if ($is_paid) {
    // 4. Fetch the user_id from the database
    $stmt = $con->prepare('SELECT `user_id` FROM `ecom_users` WHERE `user_username` = ?');
    $stmt->bind_param('s', $username);
    $stmt->execute();
    $user = $stmt->get_result()->fetch_assoc();
    $user_id = $user['user_id'];

    // 5. CLEAR THE CART: Payment is successful, so empty the user's temporary cart table
    $stmt_clear = $con->prepare('DELETE FROM `ecom_cart_details` WHERE `user_id` = ?');
    $stmt_clear->bind_param('i', $user_id);
    $stmt_clear->execute();

    // 6. Display a beautiful success message to your customer
?>
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <title>Order Successful</title>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css">
    </head>

    <body class="bg-light">
        <div class="container mt-5 text-center">
            <div class="card p-5 shadow-sm mx-auto" style="max-width: 600px; border-radius: 12px;">
                <div class="text-success mb-3" style="font-size: 4rem;">✓</div>
                <h2 class="text-brand mb-3">Payment Successful!</h2>
                <p class="text-muted">Thank you for your purchase. Your order has been placed successfully.</p>
                <hr>
                <div class="text-start bg-white p-3 border rounded font-monospace mb-4">
                    <strong>Order ID:</strong> <?php echo htmlspecialchars($order_id); ?><br>
                    <strong>Payment Reference:</strong> <?php echo htmlspecialchars($tracker); ?>
                </div>
                <a href="index.php" class="btn btn-success px-4 py-2">Continue Shopping</a>
            </div>
        </div>
    </body>

    </html>
<?php
} else {
    // Fallback if someone inspects the page or the payment failed/was altered
    echo "<div class='alert alert-danger m-5'>Payment verification failed or transaction was cancelled.</div>";
}
?>