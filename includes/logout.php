<!-- DB connection -->
<?php
include "db.php";
?>

<!-- Session start -->
<?php
session_start();
?>

<?php

$_SESSION['username'] = null;
$_SESSION['firstname'] = null;
$_SESSION['lastname'] = null;
$_SESSION['role'] = null;

//  Session unset added later
session_unset();

header("Location: ../index.php");

?>