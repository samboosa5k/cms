<!-- Connection -->
<?php
include("includes/db.php");
?>

<!-- Header -->
<?php
include("includes/header.php");
?>

<!-- Functions -->
<?php
include_once("admin/functions.php");
?>

<!-- Load vendor/pusher -->
<?php
require __DIR__ . '/vendor/autoload.php';
?>

<!-- Load .env protection -->
<?php

// Object oriented method used here, procedural way does not work
$dotenv = Dotenv\Dotenv::create(__DIR__);
$dotenv->load();


$options = array(
    'cluster' => 'eu',
    'useTLS' => true
);

$pusher = new Pusher\Pusher(
    getenv('APP_KEY'),
    getenv('APP_SECRET'),
    getenv('APP_ID'),
    $options
);

$data['message'] = "User subscribed!";
$pusher->trigger('notifications', 'message', $data);
?>

<?php
if (isset($_POST['submit'])) {
    $username = escape($_POST['username']);
    $user_email = escape($_POST['email']);
    $user_password = escape($_POST['password']);
    //  RETURN message and also do registration
    $user_creation_notification = user_registration($username, $user_email, $user_password);
    //  Trigger PUSHER on register

    $data['message'] = $username . " just subscribed!";
    $pusher->trigger('notifications', 'new_user', $data);
} else {
    $user_creation_notification = "";
}
?>


<!-- Navigation -->

<?php include "includes/navigation.php"; ?>


<!-- Page Content -->
<div class="container">

    <section id="login">
        <div class="container">
            <div class="row">
                <div class="col-xs-6 col-xs-offset-3">
                    <div class="form-wrap">
                        <h1>Register</h1>
                        <form role="form" action="registration.php" method="post" id="login-form" autocomplete="off">
                            <div class="form-group">
                                <label for="username" class="sr-only">username</label>
                                <input type="text" name="username" id="username" class="form-control" placeholder="Enter Desired Username">
                            </div>
                            <div class="form-group">
                                <label for="email" class="sr-only">Email</label>
                                <input type="email" name="email" id="email" class="form-control" placeholder="somebody@example.com">
                            </div>
                            <div class="form-group">
                                <label for="password" class="sr-only">Password</label>
                                <input type="password" name="password" id="key" class="form-control" placeholder="Password">
                            </div>

                            <!-- DISPLAY ERROR/SUCCESS message -->
                            <?php
                            if (strlen($user_creation_notification) > 1) {
                                if ($user_creation_notification != "User has been created!") {
                                    echo "<div class='form-group alert alert-warning'>$user_creation_notification</div>";
                                } else {
                                    echo "<div class='form-group alert alert-success'>$user_creation_notification</div>";
                                }
                            }
                            ?>

                            <input type="submit" name="submit" id="btn-login" class="btn btn-custom btn-lg btn-block" value="Register">
                        </form>

                    </div>
                </div> <!-- /.col-xs-12 -->
            </div> <!-- /.row -->
        </div> <!-- /.container -->
    </section>


    <hr>



    <?php include "includes/footer.php"; ?>