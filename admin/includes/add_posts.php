<?php
if (isset($_POST['submit_post'])) {
    //  variables
    $post_category_id = escape($_POST['post_category']);
    $post_title = escape($_POST['post_title']);
    $post_author = escape($_POST['post_author']);
    $post_status = escape($_POST['post_status']);

    //  Upload image
    //  'tmp_name' is a parameter specific to $_FILES before it gets moved...
    //  ...don't change this
    $post_image = $_FILES['post_image']['name'];
    $post_image_temp = $_FILES['post_image']['tmp_name'];

    //
    $post_tags = escape($_POST['post_tags']);
    $post_content = escape($_POST['post_content']);
    //  $post_content = mysqli_real_escape_string($connection, $post_content_raw);
    $post_date = date('d-m-y');
    // $post_comment_count = 0;

    //  PHP built-in function to move temporary file
    move_uploaded_file($post_image_temp, "../images/$post_image");

    //  Query time - for submitting ALL the fields
    //  Contactenation REALLY needed this time
    $query = "INSERT INTO posts(post_category_id, post_title, post_author, post_date, post_status, post_image, post_tags, post_content) ";
    $query .= "VALUES({$post_category_id},'{$post_title}','{$post_author}', now(),'{$post_status}','{$post_image}','{$post_tags}','{$post_content}')";
    $submit_post_query = mysqli_query($connection, $query);

    //  VERIFY query, this should be turned into a function because it's repeated everywhere...
    if (!$submit_post_query) {
        die("Submitting post failed!" . mysqli_error($connection));
    }

    //  CONFIRMATION: add post
    $new_post_id = mysqli_insert_id($connection);
    echo "<div class='alert alert-success'><strong><p>Post added: <a href='../post.php?p_id={$new_post_id}'>View post</a></p></strong></div>";
}
?>

<form action="" method="post" enctype="multipart/form-data" class="">
    <div class="form-group">
        <label for="category" class="">Category</label>
        <br>
        <!-- <input type="" name="post_category_id" value="<?php echo $edit_id; ?>" class="form-control"> -->
        <select name="post_category" id="post_category" class="" value="<?php echo $post_category_id; ?>">
            <!-- Query all cats -->
            <?php
            $query = "SELECT * FROM categories";
            $select_cat = mysqli_query($connection, $query);
            while ($row = mysqli_fetch_assoc($select_cat)) {
                $cat_id = $row['cat_id'];
                $cat_title = $row['cat_title'];

                echo "<option value='$cat_id' class=''>{$cat_title}</option>";
            }
            ?>
        </select>
    </div>

    <div class="form-group">

        <label for="post-title" class="">Post title</label>
        <br>
        <input type="text" name="post_title" class="form-control">
        <br>
    </div>

    <!-- <div class="form-group">
        <label for="post-author" class="">Post author</label>
        <br>
        <input type="text" name="post_author" class="form-control">
        <br>
    </div> -->

    <!-- USER SELECT -->
    <div class="form-group">
        <label for="post-author" class="">Author</label>
        <br>
        <select name="post_author" id="post_author" class="" value="<?php echo $post_author; ?>">
            <!-- Query all USERS -->
            <?php
            $query = "SELECT * FROM users";
            $select_user = mysqli_query($connection, $query);
            while ($row = mysqli_fetch_assoc($select_user)) {
                $user_id = $row['user_id'];
                $username = $row['username'];

                echo "<option value='$username' class=''>{$username}</option>";
            }
            ?>
        </select>
    </div>

    <div class="form-group">
        <label for="post-status" class="">Post status</label>
        <br>
        <!-- TOGGLE STATUS -->
        <select name="post_status" id="">
            <option value='Draft' class=''>Draft</option>
            <option value='Published' class=''>Published</option>
        </select>
    </div>

    <div class="form-group"></div>
    <label for="post-image" class="">Post image</label>
    <br>
    <input type="file" name="post_image" class="form-control">
    <br>

    <label for="post-tags" class="">Post tags</label>
    <br>
    <input type="text" name="post_tags" class="form-control">
    <br>

    <label for="post-content" class="">Post content</label>
    <br>
    <textarea name="post_content" class="form-control" id="" cols="30" rows="10">
        </textarea>
    <br>
    </div>

    <div class="form-group">
        <input type="submit" name="submit_post" class="btn btn-primary" value="Submit post">
    </div>
</form>