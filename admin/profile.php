<!--  Admin PROFILE page -->

<!-- Include header -->
<?php
include("includes/admin_header.php");
?>

<!-- CHECK for user -->
<?php
if (isset($_SESSION['username'])) {
    $username_u = $_SESSION['username'];
    $query = "SELECT * FROM users WHERE username = '{$username_u}'";
    $select_profile_query = mysqli_query($connection, $query);

    while ($row = mysqli_fetch_assoc($select_profile_query)) {
        $user_id = $row['user_id'];
        $username = $row['username'];
        $user_firstname = $row['user_firstname'];
        $user_lastname = $row['user_lastname'];
        $user_email = $row['user_email'];
        $user_role = $row['user_role'];
        $user_password = $row['user_password'];
        $user_image = $row['user_image'];
    }
}
?>

<?php
if (isset($_POST['edit_user'])) {
    //  variables
    //  If session is not redeclared, then the correct details won't be loaded next time
    $username = $_POST['username'];
    $_SESSION['username'] = $username;

    $user_firstname = $_POST['user_firstname'];
    $user_lastname = $_POST['user_lastname'];

    //  Upload image
    $user_image = $_FILES['user_image']['name'];
    $user_image_temp = $_FILES['user_image']['tmp_name'];

    //
    $user_email = $_POST['user_email'];
    $user_role = $_POST['user_role'];
    $user_password = $_POST['user_password'];

    $query = "UPDATE users SET ";
    $query .= "username = '{$username}', ";
    $query .= "user_firstname = '{$user_firstname}', ";
    $query .= "user_email = '{$user_email}', ";
    $query .= "user_role = '{$user_role}', ";
    $query .= "user_password = '{$user_password}', ";
    //  COMMA ENDS here after the $post_image
    $query .= "user_image = '{$user_image}' ";
    //  VERY IMPORTANT here to refer to original session username on update query
    $query .= "WHERE username = '{$username_u}' ";

    $edit_user_query = mysqli_query($connection, $query);

    //  VERIFY query, this should be turned into a function because it's repeated everywhere...
    if (!$edit_user_query) {
        die("Edit user failed!" . mysqli_error($connection));
    }
}
?>

<div id="wrapper">

    <!-- Navigation -->
    <?php include("includes/admin_navigation.php"); ?>

    <div id="page-wrapper">

        <div class="container-fluid">

            <!-- Page Heading -->
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">
                        Welcome to your profile page, <small><?php echo $_SESSION['username']; ?>!</small>
                    </h1>

                    <form action="" method="post" enctype="multipart/form-data" class="">
                        <div class="form-group">

                            <label for="username" class="">Username</label>
                            <br>
                            <input type="text" name="username" value="<?php echo $username; ?>" class="form-control">
                            <br>

                            <label for="user-image" class="">User image</label>
                            <br>
                            <input type="file" name="user_image" class="form-control">
                            <br>

                            <label for="user-firstname" class="">Firstname</label>
                            <br>
                            <input type="text" name="user_firstname" value="<?php echo $user_firstname; ?>" class="form-control">
                            <br>

                            <label for="user-lastname" class="">Lastname</label>
                            <br>
                            <input type="text" name="user_lastname" value="<?php echo $user_lastname; ?>" class="form-control">
                            <br>

                            <label for="user-email" class="">User email</label>
                            <br>
                            <input type="text" name="user_email" value="<?php echo $user_email; ?>" class="form-control">
                            <br>

                            <label for="user-role" class="">User role</label>
                            <br>
                            <select name="user_role" id="user_role" class="">

                                <option value='standard' class=''><?php echo $user_role; ?></option>;
                                <?php
                                //
                                if ($user_role == "Admin") {
                                    echo "<option value='standard' class=''>Standard</option>";
                                } else {
                                    echo "<option value='admin' class=''>Admin</option>";
                                }
                                ?>

                            </select>
                            <br>

                            <label for="user-password" class="">User password</label>
                            <br>
                            <input type="password" name="user_password" value="<?php echo $user_password; ?>" class="form-control">
                            <br>
                        </div>

                        <div class="form-group">
                            <input type="submit" name="edit_user" class="btn btn-primary" value="Update profile">
                        </div>
                    </form>

                </div>
            </div>
            <!-- /.row -->

        </div>
        <!-- /.container-fluid -->

    </div>
    <!-- /#page-wrapper -->

    <!-- Include footer -->
    <?php
    include("includes/admin_footer.php");
    ?>