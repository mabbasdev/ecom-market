<?php
session_start();
include('includes/dbconnect.php');
include('includes/common_functions.php');

if (isset($_SESSION['username'])) {
  echo "<script>window.location.href='page-account.html'</script>";
  exit();
}

$gotocheckout = 0;
if (isset($_GET['checkout']) && $_GET['checkout'] == 1) {
  $gotocheckout = 1;
  $_SESSION['toCheckout'] = 1;
} else if (isset($_SESSION['toCheckout']) && $_SESSION['toCheckout'] == 1) {
  $gotocheckout = 1;
}

if (isset($_POST['loginSubmit'])) {
  $loginUser = trim($_POST['loginUser']);
  $loginPass = trim($_POST['loginPassword']);

  if (empty($loginUser) || empty($loginPass)) {
    $_SESSION['toast-message'] = "Fill the required fields";
    $_SESSION['toast-icon'] = "warning";
    header("Location: login.php");
    exit();
  }

  $loginQuery = "SELECT * FROM `ecom_users` WHERE `user_username` = ? OR `user_email`=?";
  $stmt = $con->prepare($loginQuery);
  $stmt->bind_param("ss", $loginUser, $loginUser);
  $stmt->execute();

  $result = $stmt->get_result();
  $row_count = $result->num_rows;
  if ($row_count > 0) {
    $row_data = $result->fetch_assoc();
    if (password_verify($loginPass, $row_data['user_password'])) {
      $_SESSION['username'] = $row_data['user_username'];
      $user_id = $row_data['user_id'];
      $_SESSION['user_id'] = $user_id;

      if (isset($_SESSION['cart']) && count($_SESSION['cart']) > 0) {
        foreach ($_SESSION['cart'] as $pid => $qty) {
          $checkcart = $con->prepare("SELECT * FROM `ecom_cart_details` WHERE `user_id`=? AND `product_id`=?");
          $checkcart->bind_param('ii', $user_id, $pid);
          $checkcart->execute();
          $checkcart_result = $checkcart->get_result();
          if ($checkcart_result->num_rows > 0) {
            $update = $con->prepare("UPDATE ecom_cart_details SET quantity = quantity+? WHERE user_id=? AND product_id=?");
            $update->bind_param('iii', $qty, $user_id, $pid);
            $update->execute();
          } else {
            $insert = $con->prepare("INSERT INTO `ecom_cart_details` (user_id, product_id, quantity) VALUES (?, ?, ?)");
            $insert->bind_param('iii', $user_id, $pid, $qty);
            $insert->execute();
          }
        }
        unset($_SESSION['cart']);
      }

      $goingtocheckout = false;
      if (isset($_POST['gotocheckout']) && $_POST['gotocheckout'] == 1) {
        $goingtocheckout = true;
      } else if ($_SESSION['gotocheckout'] && $_SESSION['gotocheckout'] == 1) {
        $goingtocheckout = true;
      }
      if ($goingtocheckout) {
        unset($_SESSION['gotocheckout']);
        $_SESSION['toast-message'] = "Welcome Back! Proceed to Checkout!";
        $_SESSION['toast-icon'] = "success";
        header("Location: checkout.php");
        exit();
      }

      $_SESSION['toast-message'] = "Welcome Back!";
      $_SESSION['toast-icon'] = "success";
      header("Location: index.php");
      exit();
    } else {
      $_SESSION['toast-message'] = "Username or Password is wrong";
      $_SESSION['toast-icon'] = "info";
      header("Location: login.php");
      exit();
    }
  } else {
    $_SESSION['toast-message'] = "Username or Password is wrong";
    $_SESSION['toast-icon'] = "error";
    header("Location: login.php");
    exit();
  }
}


?>
<?php include('includes/header.php'); ?>
<?php include('includes/navbar.php'); ?>

<script>
  document.title = 'Login - Ecom Marketplace';
</script>

<?php include("includes/loginForm.php"); ?>

<?php include('includes/footer-nav.php'); ?>
<?php include('includes/bottom.php'); ?>
</body>

</html>