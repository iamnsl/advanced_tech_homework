<?php
//include_once 'const.php';

session_start();

if (isset($_SESSION['id'])) {
    $username = $_SESSION['user'];
} else {
    $usernam = 'User';
}
$display = "";
if (isset($username)) {
    $display = '<p class="h5 name" style="margin: 0;">' . $username . '</p><i class="fas fa-user-tie"></i>';
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="assets/bootstrap.min.css">
  <link rel="stylesheet" href="assets/Font_Awesome/all.min.css">
  <link rel="stylesheet" href="styles/main.css">
  <link rel="shortcut icon" href="assets/illustrations/favicon.svg" type="image/x-icon">
  <title>Student Space</title>
</head>

<body>

  <header class="header shadow-md p-4 shadow-sm">
    <ul class="container-xxl cont">
      <a href="index.php">
        <h2 class=""><i class="fas fa-user-graduate "></i>Student Space</h2>
      </a>
      <div class="user">
        <a href="profile.php" style="display: flex;
    align-items: center;">
          <?php echo $display; ?>
        </a>
        <!-- <i class="fas fa-user-tie"></i> -->
        <?php if (!isset($_SESSION['id'])): ?>
        <a href="login.php">
          <li class="btn btn-outline-dark">Log In</li>
        </a>
        <?php else: ?>
        <a href="../app/Users.php?q=logout">
          <li class="btn btn-outline-dark">Log Out</li>
        </a>
      </div>
      <?php endif; ?>
    </ul>

  </header>