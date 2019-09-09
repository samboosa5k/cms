<!-- Session start -->
<?php
session_start();
?>

<!-- DB connection -->
<?php
include "db.php";
?>

<!-- Functions -->
<?php
include "../admin/functions.php";
?>


<!-- Login handlin -->
<?php

if (isset($_POST['login'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];
    login_try($username, $password);
}
