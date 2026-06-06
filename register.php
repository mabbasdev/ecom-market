<?php
session_start();
include('includes/dbconnect.php');
include('includes/common_functions.php');

if (isset($_SESSION['username'])) {
  echo "<script>window.location.href='page-account.html'</script>";
  exit();
}

if (isset($_POST['registerUser'])) {
  $userFullName = trim($_POST['fullName']);
  $userEmail = trim($_POST['email']);
  $userName = trim($_POST['username']);
  $userPass = trim($_POST['password']);
  $userRePass = trim($_POST['repassword']);

  // 1. Validation Checks
  if (empty($userFullName) || empty($userEmail) || empty($userName) || empty($userPass) || empty($userRePass)) {
    $_SESSION['toast-message'] = "Fill the required fields";
    $_SESSION['toast-icon'] = "warning";
    header("Location: register.php");
    exit();
  }

  if ($userPass !== $userRePass) {
    $_SESSION['toast-message'] = "Passwords do not match";
    $_SESSION['toast-icon'] = "warning";
    header("Location: register.php");
    exit();
  }

  // Example updated password regex: length between 8-20 characters
  if (!preg_match("/^.{8,20}$/", $userPass)) {
    $_SESSION['toast-message'] = "Password must be between 8 and 20 characters long.";
    $_SESSION['toast-icon'] = "warning";
    header("Location: register.php");
    exit();
  }

  // 2. Database Check (Does user exist?)
  $checkQuery = "SELECT * FROM `ecom_users` WHERE `user_username`=? OR `user_email`=?";
  $stmtCheck = $con->prepare($checkQuery);
  $stmtCheck->bind_param("ss", $userName, $userEmail);
  $stmtCheck->execute();
  $result = $stmtCheck->get_result();

  if ($result->num_rows > 0) {
    $_SESSION['toast-message'] = "Username or Email Already Exists.";
    $_SESSION['toast-icon'] = "error";
    header("Location: register.php");
    exit();
  }

  // 3. Insert user if all checks pass
  $hashedPass = password_hash($userPass, PASSWORD_DEFAULT);
  $userInsertQuery = "INSERT INTO `ecom_users` (`user_username`, `user_full_name`, `user_email`, `user_password`) VALUES (?, ?, ?, ?)";

  $stmtInsert = $con->prepare($userInsertQuery);
  $stmtInsert->bind_param('ssss', $userName, $userFullName, $userEmail, $hashedPass);

  if ($stmtInsert->execute()) {
    $_SESSION['username'] = $userFullName;
    $_SESSION['toast-message'] = "Account Created Successfully!";
    $_SESSION['toast-icon'] = "success";

    // Redirect to index page
    echo "<script>window.location.href='index.php'</script>";
    exit();
  } else {
    $_SESSION['toast-message'] = "Something went wrong during insertion.";
    $_SESSION['toast-icon'] = "error";
    header("Location: register.php");
    exit();
  }
}
?>
<?php include('includes/header.php'); ?>
<?php include('includes/navbar.php'); ?>

<script>
  document.title = 'Create Account - Ecom Marketplace';
</script>

<main class="main">

  <section class="section-box shop-template mt-60">

    <div class="container">

      <div class="row mb-100">

        <div class="col-lg-1"></div>

        <div class="col-lg-5">

          <h3>Create an account</h3>

          <p class="font-md color-gray-500">Access to all features. No credit card required.</p>

          <form class="form-register mt-30 mb-30" action="" enctype="multiform/form-data" method="post">

            <div class="form-group">

              <label class="mb-5 font-sm color-gray-700">Full Name *</label>

              <input class="form-control" type="text" name="fullName" placeholder="Steven job" required>

            </div>

            <div class="form-group">

              <label class="mb-5 font-sm color-gray-700">Email *</label>

              <input class="form-control" type="text" name="email" placeholder="stevenjob@gmail.com" required>

            </div>

            <div class="form-group">

              <label class="mb-5 font-sm color-gray-700">Username *</label>

              <input class="form-control" type="text" name="username" placeholder="stevenjob">

            </div>

            <div class="form-group">

              <label class="mb-5 font-sm color-gray-700">Password *</label>

              <input class="form-control" type="password" name="password" placeholder="******************" required>

            </div>

            <div class="form-group">

              <label class="mb-5 font-sm color-gray-700">Re-Password *</label>

              <input class="form-control" type="password" name="repassword" placeholder="******************" required>

            </div>

            <div class="form-group">

              <label>

                <input class="checkagree" type="checkbox" required>By clicking Register button, you agree our terms and policy,

              </label>

            </div>

            <div class="form-group">

              <input class="font-md-bold btn btn-buy" type="submit" name="registerUser" value="Sign Up">

            </div>

            <div class="mt-20"><span class="font-xs color-gray-500 font-medium">Already have an account?</span><a

                class="font-xs color-brand-3 font-medium" href="login.php"> Sign In</a></div>

          </form>

        </div>

        <div class="col-lg-5">

          <div class="box-login-social pt-65 pl-50">

            <h5 class="text-center">Use Social Network Account</h5>

            <div class="box-button-login mt-25"><a class="btn btn-login font-md-bold color-brand-3 mb-15">Sign up

                with<img src="images/google.svg" alt="Ecom"></a><a

                class="btn btn-login font-md-bold color-brand-3 mb-15">Sign up with<span

                  class="color-blue font-md-bold">Facebook</span></a><a

                class="btn btn-login font-md-bold color-brand-3 mb-15">Sign up with<img src="images/amazon.svg"

                  alt="Ecom"></a></div>

            <div class="mt-10 text-center"><span class="font-xs color-gray-900">Buying for work?</span><a

                class="color-brand-1 font-xs" href="#">Create a free business account</a></div>

          </div>

        </div>

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