<?php
if (!isset($page_title)) {
  $page_title = 'Welcome to Ecom Marketplace';
}
$path_prefix = "";
if (strpos($_SERVER['PHP_SELF'], 'users_area') !== false) {
  $path_prefix = "../";
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <meta name="msapplication-TileColor" content="#0E0E0E">
  <meta name="template-color" content="#0E0E0E">
  <meta name="description" content="Index page">
  <meta name="keywords" content="index, page">
  <meta name="author" content="">
  <link rel="shortcut icon" type="image/x-icon" href="<?php echo $path_prefix; ?>images/favicon.svg">
  <link href="<?php echo $path_prefix; ?>css/style.css" rel="stylesheet">

  <?php if (strpos($_SERVER['PHP_SELF'], 'users_area') !== false) {

    echo '<link href="<?php echo $path_prefix; ?>css/style.css" rel="stylesheet">';
  } ?>
  <title><?php echo htmlentities($page_title); ?></title>
</head>

<body>
  <?php include("toast-notify.php"); ?>
  <!-- <button onclick="toast.show('Project deployed!', 'success')">
  Show Toast
</button> -->