<?php
session_start();

// 1. Set the toast message first
$_SESSION['toast-message'] = "Logged out successfully!";
$_SESSION['toast-icon'] = "success";

// 2. Clear only the user data, leaving the toast data intact
unset($_SESSION['username']); 
// Add any other user data keys here if you have them, e.g., unset($_SESSION['user_id']);

// 3. Fix the typo and redirect
header("Location: index.php"); 
exit();

    // <?php
// session_start();

// //? 1. Initialize the toast message before destroying the existing session variables
// $_SESSION['toast-message'] = "Logged out successfully!";
// $_SESSION['toast-icon'] = "success";

// //? 2. Keep the toast variables safe while clearing everything else
// $toastMsg = $_SESSION['toast-message'];
// $toastIcon = $_SESSION['toast-icon'];

// // 3. Unset all of the session variables
// $_SESSION = array();

// //? 4. If it's desired to kill the session entirely, destroy the session cookie as well
// if (ini_get("session.use_cookies")) {
//     $params = session_get_cookie_params();
//     setcookie(session_name(), '', time() - 42000,
//         $params["path"], $params["domain"],
//         $params["secure"], $params["httponly"]
//     );
// }

// //? 5. Destroy the server-side session file
// session_destroy();

// //? 6. Start a brand new session context just to pass the toast to the index page
// session_start();
// $_SESSION['toast-message'] = $toastMsg;
// $_SESSION['toast-icon'] = $toastIcon;

// //? 7. Redirect back to the landing page
// header("Location: index.php"); // Adjust path if index.php is in a different directory
// exit();
?>