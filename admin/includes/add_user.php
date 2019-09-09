<!-- Include functions -->
<?php
include("../functions.php");
?>

<!-- Admin check -->
<?php
if (!is_admin()) {
    header("Location: ../index.php");
};
?>

<?php
if (isset($_POST['add_user'])) {
    //  variables
    //$user_id = $_POST['user_id'];
    $username = escape($_POST['username']);
    $user_firstname = escape($_POST['user_firstname']);
    $user_lastname = escape($_POST['user_lastname']);
    $user_email = escape($_POST['user_email']);
    $user_role = escape($_POST['user_role']);
    $user_password = escape($_POST['user_password']);
    //  ENCRYPTION
    $user_password = password_hash($user_password, PASSWORD_DEFAULT);

    //  Upload image
    //  'tmp_name' is a parameter specific to $_FILES before it gets moved...
    //  ...don't change this
    $user_image = $_FILES['user_image']['name'];
    $user_image_temp = $_FILES['user_image']['tmp_name'];

    //  PHP built-in function to move temporary file
    //move_uploaded_file($user_image_temp, "../images/$user_image");

    //  Query time - for submitting ALL the fields
    //  Contactenation REALLY needed this time
    $query = "INSERT INTO users(username, user_firstname, user_lastname, user_image, user_email, user_role, user_date, user_password) ";
    $query .= "VALUES('{$username}','{$user_firstname}','{$user_lastname}','{$user_image}','{$user_email}','{$user_role}', now(),'{$user_password}')";
    $add_user_query = mysqli_query($connection, $query);

    //  VERIFY query, this should be turned into a function because it's repeated everywhere...
    if (!$add_user_query) {
        die("Adding user failed!" . mysqli_error($connection));
    } else {
        echo "User creation succeeded!: " . "<a href='./users.php'>View users</a>";
    }
}
?>

<form action="" method="post" enctype="multipart/form-data" class="">
    <div class="form-group">

        <label for="username" class="">Username</label>
        <br>
        <input type="text" name="username" class="form-control">
        <br>

        <label for="user-image" class="">User image</label>
        <br>
        <input type="file" name="user_image" class="form-control">
        <br>

        <label for="user-firstname" class="">Firstname</label>
        <br>
        <input type="text" name="user_firstname" class="form-control">
        <br>

        <label for="user-lastname" class="">Lastname</label>
        <br>
        <input type="text" name="user_lastname" class="form-control">
        <br>

        <label for="user-email" class="">User email</label>
        <br>
        <input type="text" name="user_email" class="form-control">
        <br>

        <label for="user-role" class="">User role</label>
        <br>
        <select name="user_role" id="user_role" class="">

            <option value='standard' class=''>- Select -</option>;
            <option value='admin' class=''>Admin</option>;
            <option value='standard' class=''>Standard</option>;

        </select>
        <br>

        <label for="user-password" class="">User password</label>
        <br>
        <input type="text" name="user_password" class="form-control">
        <br>
    </div>

    <div class="form-group">
        <input type="submit" name="add_user" class="btn btn-primary" value="Add user">
    </div>
</form>