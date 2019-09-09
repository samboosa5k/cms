<!-- 
    Initiate buffering, so that all requests are sent
    at the same time instead of one by one 
-->
<?php
ob_start();
session_start();
?>

<?php
if (!isset($_SESSION['role'])) {

    header("Location: ../index.php");
}
?>

<!-- Include DB -->
<?php
include("../includes/db.php");
?>

<!-- Include Functions to all pages -->
<?php
include("functions.php");
?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>SB Admin - Bootstrap Admin Template</title>

    <!-- Bootstrap Core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="css/sb-admin.css" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>

    <!-- Bulk checking option -->
    <script type="text/javascript">
        function checkAll() {
            var checkboxes = document.getElementsByName("checkboxArray[]");
            for (var i = 0; i <= checkboxes.length; i++) {
                checkboxes[i].checked = true;
            }
        }
    </script>

</head>

<body>