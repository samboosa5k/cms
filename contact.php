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

<?php

if (isset($_POST['submit'])) {
    $to = "jasper.verbon@gmail.com";
    $email = "From: " . escape($_POST['email']);
    $subject = escape($_POST['subject']);
    $message = escape($_POST['message']);

    if (empty($email) || empty($subject) || empty($message)) {
        $mail_sending_notification = "Fields can NOT be empty!";
    } else {
        $mail_sending_notification = "Mail has been sent!";
        mail($to, $subject, $message, $email);
        echo $email;
    }
} else {
    $mail_sending_notification = "";
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
                        <h1>Contact</h1>
                        <form role="form" action="contact.php" method="post" id="login-form" autocomplete="off">

                            <div class="form-group">
                                <label for="email" class="sr-only">Email</label>
                                <input type="email" name="email" id="email" class="form-control" placeholder="somebody@example.com">
                            </div>

                            <div class="form-group">
                                <label for="subject" class="sr-only">Subject</label>
                                <input type="text" name="subject" id="subject" class="form-control" placeholder="Hello, I'd like to know more about...">
                            </div>

                            <div class="form-group">
                                <label for="message" class="sr-only">Message</label>
                                <textarea name="message" class="form-control" rows="16"></textarea>
                            </div>

                            <!-- DISPLAY ERROR/SUCCESS message -->
                            <?php
                            if (strlen($mail_sending_notification) > 1) {
                                if ($mail_sending_notification == "Fields can NOT be empty!") {
                                    echo "<div class='form-group alert alert-warning'>$mail_sending_notification</div>";
                                } else {
                                    echo "<div class='form-group alert alert-success'>$mail_sending_notification</div>";
                                }
                            }
                            ?>

                            <input type="submit" name="submit" id="btn-login" class="btn btn-custom btn-lg btn-block" value="Send mail">
                        </form>

                    </div>
                </div> <!-- /.col-xs-12 -->
            </div> <!-- /.row -->
        </div> <!-- /.container -->
    </section>


    <hr>



    <?php include "includes/footer.php"; ?>