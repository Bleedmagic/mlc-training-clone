<?php
// require_once 'src/config/db.php';
// session_start();
?>

<?php include 'src/includes/header.php'; ?>

<?php
$page = $_GET['page'] ?? 'home';
$allowed = ['home', 'challenges'];

if (in_array($page, $allowed)) {
  include "src/views/{$page}.php";
} else {
  include "src/views/404.php";
}
?>

<?php include 'src/includes/footer.php'; ?>

