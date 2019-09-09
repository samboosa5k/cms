<?php

if (isset($_GET['edit_id'])) {
    $edit_id = $_GET['edit_id'];
}

$query = "SELECT * FROM posts WHERE post_id = {$edit_id}";
$select_edit_post = mysqli_query($connection, $query);

while ($row = mysqli_fetch_assoc($select_edit_post)) {
    $post_author = $row['post_author'];
    $post_title = $row['post_title'];
    $post_category_id = $row['post_category_id'];
    $post_status = $row['post_status'];
    $post_image_current = $row['post_image'];
    $post_tags = $row['post_tags'];
    $post_comment_count = $row['post_comment_count'];
    $post_date = $row['post_date'];
    $post_content = $row['post_content'];
}

//ISSET statment here
if (isset($_POST['update_post'])) {
    //
    $post_category = $_POST['post_category'];
    $post_title_raw = $_POST['post_title'];
    $post_title = mysqli_real_escape_string($connection, $post_title_raw);
    $post_author = $_POST['post_author'];
    $post_status = $_POST['post_status'];
    $post_tags = $_POST['post_tags'];

    //  Images

    $post_image = $_FILES['post_image']['name'];
    $post_image_temp = $_FILES['post_image']['tmp_name'];

    //  Prevent SQL/string problems
    $post_content_raw = $_POST['post_content'];
    $post_content = mysqli_real_escape_string($connection, $post_content_raw);

    move_uploaded_file($post_image_temp, "../images/$post_image");


    $query = "UPDATE posts SET ";
    $query .= "post_title = '{$post_title}', ";
    $query .= "post_category_id = '{$post_category}', ";
    $query .= "post_date = now(), ";
    $query .= "post_author = '{$post_author}', ";
    $query .= "post_status = '{$post_status}', ";
    $query .= "post_tags = '{$post_tags}', ";
    $query .= "post_content = '{$post_content}', ";
    //  UPDATE / KEEP post_image
    if (empty($post_image)) {
        echo "POST IMAGE EMPTY, keeping old value";
        $query .= "post_image = '{$post_image_current}' ";
    } else {
        $query .= "post_image = '{$post_image}' ";
    }

    $query .= "WHERE post_id = {$edit_id} ";

    $update_post_query = mysqli_query($connection, $query);

    if (!$update_post_query) {
        die("Query fail" . mysqli_error($connection));
    }

    //  CONFIRMATION: edit post
    echo "<div class='alert alert-success'><strong><p>Post updated: <a href='../post.php?p_id={$edit_id}'>View post</a></p></strong></div>";
}

?>

<form action="" method="post" enctype="multipart/form-data" class="">
    <div class="form-group">
        <label for="post-category-id" class="">Post category ID</label>
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
        <br>
    </div>
    <div class="form-group">

        <label for="post-title" class="">Post title</label>
        <br>
        <input type="text" name="post_title" value="<?php echo $post_title; ?>" class="form-control">
        <br>
    </div>

    <!-- USER SELECT -->
    <div class="form-group">
        <label for="post-author" class="">Author</label>
        <br>
        <select name="post_author" id="post_author">
            <!-- Toggle authors -->
            <!-- Default -->
            <option value='<?php echo $post_author; ?>' class=''>
                <?php echo $post_author; ?>
            </option>
            <!-- ALl users -->
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
            <option value='<?php echo $post_status; ?>' class=''>
                <?php echo $post_status; ?>
            </option>
            <?php
            if ($post_status == 'Published') {
                echo "<option value='Draft' class=''>Draft</option>";
            } else {
                echo "<option value='Published' class=''>Published</option>";
            }
            ?>
        </select>
    </div>

    <div class="form-group">
        <label for="post-image" class="">Post image</label>
        <br>
        <img src="../images/<?php echo $post_image_current; ?>">
        <br>
        <input type="file" value="" name="post_image" class="form-control">
        <br>

        <label for="post-tags" class="">Post tags</label>
        <br>
        <input type="text" value="<?php echo $post_tags; ?>" name="post_tags" class="form-control">
        <br>

        <label for="post-content" class="">Post content</label>
        <br>
        <textarea name="post_content" class="form-control" id="" cols="30" rows="10"><?php echo $post_content; ?>
        </textarea>
        <br>
    </div>

    <div class="form-group">
        <input type="submit" name="update_post" class="btn btn-primary" value="Update post">
    </div>
</form>