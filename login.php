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

<main class="main">
  <section class="section-box shop-template mt-60">
    <div class="container">
      <div class="row mb-100">
        <div class="col-lg-1"></div>
        <div class="col-lg-5">
          <h3>Login to Your Account</h3>
          <p class="font-md color-gray-500">Welcome back!</p>
          <form action="" method="post" class="form-register mt-30 mb-30">
            <div class="form-group">
              <label class="mb-5 font-sm color-gray-700">Email / Phone / Username *</label>
              <input class="form-control" type="text" name="loginUser" placeholder="stevenjob@gmail.com">
            </div>
            <div class="form-group">
              <label class="mb-5 font-sm color-gray-700">Password *</label>
              <input class="form-control" type="password" name="loginPassword" placeholder="******************">
            </div>
            <div class="row">
              <div class="col-lg-6">
                <div class="form-group">
                  <label class="color-gray-500 font-xs">
                    <input class="checkagree" type="checkbox">Remember me
                  </label>
                </div>
              </div>
              <div class="col-lg-6 text-end">
                <div class="form-group"><a class="font-xs color-gray-500" href="#">Forgot your password? </a></div>
              </div>
            </div>
            <div class="form-group">
              <?php if ($gotocheckout): ?>
                <input type="hidden" name="gotocheckout" value="1">
              <?php endif; ?>
              <input class="font-md-bold btn btn-buy" type="submit" name="loginSubmit" value="Login">
            </div>
            <div class="mt-20"><span class="font-xs color-gray-500 font-medium">Have not an account?</span><a
                class="font-xs color-brand-3 font-medium" href="register.php">Sign Up</a></div>
          </form>
        </div>
        <div class="col-lg-5"></div>
      </div>
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
</main>

<?php include('includes/footer-nav.php'); ?>
<?php include('includes/bottom.php'); ?>
</body>

</html>