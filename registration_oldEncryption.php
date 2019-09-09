<?php include "includes/db.php"; ?>
<?php include "includes/header.php"; ?>

<?php
if (isset($_POST['submit'])) {
    $username = $_POST['username'];
    $user_email = $_POST['email'];
    $user_password = $_POST['password'];

    if (empty($username) || empty($user_email) || empty($user_password)) {
        $user_creation_notification = "Fields can NOT be empty!";
    } else {
        $username = mysqli_real_escape_string($connection, $username);
        $user_email = mysqli_real_escape_string($connection, $user_email);
        $user_password = mysqli_real_escape_string($connection, $user_password);
        $user_creation_notification = "User has been created!";

        //  Retrieve SALT for encryption
        $query = "SELECT randSalt FROM users";
        $select_randSalt_query = mysqli_query($connection, $query);

        if (!$select_randSalt_query) {
            die("randSalt selection failed: " . $connection);
        }

        $randSalt_row = mysqli_fetch_array($select_randSalt_query);
        $randSalt_row = $randSalt_row[0];

        //  Adding user to db
        $query = "INSERT INTO users(username, user_email, user_password, user_role) ";
        $user_password = crypt($user_password, $randSalt_row);
        $query .= "VALUES('{$username}','{$user_email}','{$user_password}','Standard')";
        $insert_newUser_query = mysqli_query($connection, $query);

        if (!$insert_newUser_query) {
            die("Inserting new user failed. Error code == " . mysqli_error($connection));
        }
    }
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
                                if ($user_creation_notification == "Fields can NOT be empty!") {
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