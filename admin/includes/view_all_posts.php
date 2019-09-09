<?php
if (isset($_GET['source'])) {
    $source = $_GET['source'];

    switch ($source) {
        case ("test"):
            echo "<h1>Test source</h1>";
            break;

        case ("add_posts"):
            include("includes/add_posts.php");
            break;

        case ("edit_posts"):
            include("includes/edit_posts.php");
            break;
        default:
            //
            break;
    }
} else {
    if (isset($_POST['checkboxArray'])) {
        foreach ($_POST['checkboxArray'] as $checkboxValue) {
            $bulk_options = $_POST['bulk_options'];
            switch ($bulk_options) {
                case ("Published"):
                    echo "Published";
                    $query = "UPDATE posts SET post_status='Published' WHERE post_id = {$checkboxValue}";
                    $update_query_bulk = mysqli_query($connection, $query);
                    header("Location: ./posts.php");
                    break;
                case ("Draft"):
                    echo "Draft";
                    $query = "UPDATE posts SET post_status='Draft' WHERE post_id = {$checkboxValue}";
                    $update_query_bulk = mysqli_query($connection, $query);
                    header("Location: ./posts.php");
                    break;
                case "delete":
                    $query = "DELETE FROM posts WHERE post_id = {$checkboxValue}";
                    $delete_query_bulk = mysqli_query($connection, $query);
                    header("Location: ./posts.php");
                    break;
                case "duplicate":
                    $query = "SELECT * FROM posts WHERE post_id = '{$checkboxValue}'";
                    $select_post_query = mysqli_query($connection, $query);
                    while ($row = mysqli_fetch_array($select_post_query)) {
                        $post_author = $row['post_author'];
                        $post_title = $row['post_title'];
                        $post_category_id = $row['post_category_id'];
                        $post_status = $row['post_status'];
                        $post_image = $row['post_image'];
                        $post_tags = $row['post_tags'];
                        $post_date = $row['post_date'];
                        $post_content = $row['post_content'];
                    }
                    //  DUPLICATE insertion query
                    $query = "INSERT INTO posts(post_category_id, post_title, post_author, post_date, post_status, post_image, post_tags, post_content) ";
                    $query .= "VALUES({$post_category_id},'{$post_title}','{$post_author}', now(),'{$post_status}','{$post_image}','{$post_tags}','{$post_content}')";
                    $duplicate_query = mysqli_query($connection, $query);

                    if (!$duplicate_query) {
                        die("Duplicate failed: " . mysqli_error($connection));
                    }

                    break;
            }
        }
    }

    ?>

<form action="" method="post">
    <!--  Table start -->
    <table class="table table-bordered table-hover">
        <div id="bulkOptionsContainer" style="padding:0;" class="col-xs-4">
            <select class="form-control" name="bulk_options">
                <!-- the VALUES below are CARRIED by bulk_options -->
                <option value="">- Select option -</option>
                <option value="Published">Publish</option>
                <option value="Draft">Draft</option>
                <option value="duplicate">Duplicate</option>
                <option value="delete">Delete</option>
            </select>
        </div>

        <div class="col-xs-4">
            <input type="submit" name="submit" class="btn btn-success" value="Apply">
            <a class="btn btn-primary" href="posts.php?source=add_posts">Add post</a>
        </div>

        <br>
        <thead>
            <tr>
                <!-- Posts column headers -->
                <th><input type="checkbox" onclick="checkAll();"></th>
                <th>ID</th>
                <th>Author</th>
                <th>Title</th>
                <th>Category</th>
                <th>Status</th>
                <th>Image</th>
                <th>Tags</th>
                <th>Comments</th>
                <th>Date</th>
                <th>Views</th>
            </tr>
        </thead>

        <tbody>
            <?php

                if (!isset($_GET['source'])) {
                    if (isset($_GET['author'])) {
                        $author = $_GET['author'];
                        $query = "SELECT * FROM posts WHERE post_author='$author' ORDER BY post_id DESC";
                    } else {
                        $query = "SELECT * FROM posts ORDER BY post_id DESC";
                    }
                    $select_post = mysqli_query($connection, $query);

                    //  Rows with post content
                    while ($row = mysqli_fetch_assoc($select_post)) {
                        $post_id = $row['post_id'];
                        $post_author = $row['post_author'];
                        $post_user = $row['post_user'];
                        $post_title = $row['post_title'];
                        $post_category_id = $row['post_category_id'];
                        $post_status = $row['post_status'];
                        $post_image = $row['post_image'];
                        $post_tags = $row['post_tags'];
                        $post_comment_count = $row['post_comment_count'];
                        $post_date = $row['post_date'];
                        $post_views = $row['post_views'];

                        //  Post column content (UNDER headers)
                        echo "<tr>";
                        echo "<td><input class='checkboxes' type='checkbox' name='checkboxArray[]' value='$post_id'></td>";
                        echo "<td>{$post_id}</td>";

                        //  show AUTHOR
                        echo "<td>{$post_author}</td>";

                        echo "<td><a href='../post.php?p_id={$post_id}'>{$post_title}</a></td>";

                        //  display CATEGORY
                        $query = "SELECT * FROM categories WHERE cat_id = $post_category_id";
                        $display_category = mysqli_query($connection, $query);

                        while ($row = mysqli_fetch_assoc($display_category)) {
                            $cat_id = $row['cat_id'];
                            $cat_title = $row['cat_title'];
                            echo "<td>{$cat_title}</td>";
                        }

                        //  Count comments based on post_id
                        $query = "SELECT * FROM comments WHERE comment_post_id = $post_id";
                        $select_relevant_comments = mysqli_query($connection, $query);
                        $row = mysqli_fetch_array($select_relevant_comments);
                        $comment_id = $row['comment_id'];
                        $count_relevant_comments = mysqli_num_rows($select_relevant_comments);

                        //
                        echo "<td>{$post_status}</td>";
                        echo "<td><a href='../images/{$post_image}'>{$post_image}</a></td>";
                        echo "<td>{$post_tags}</td>";
                        echo "<td><a href='post_related_comments.php?id=$post_id'>{$count_relevant_comments}</a></td>";
                        echo "<td>{$post_date}</td>";
                        echo "<td>{$post_views}<br>
                        <a href='./posts.php?views_reset={$post_id}'><p class='label label-warning'>Reset</p></a></td>";
                        echo "<td><a href='posts.php?source=edit_posts&amp;edit_id={$post_id}'>Edit</a></td>";
                        ?>

            <!-- DELETE post, method = post -->
            <form method="post">
                <input type="hidden" name="post_id" value="<?php echo $post_id; ?>">
                <td><input type="submit" name="delete" value="Delete"></td>
            </form>

            <?php
                        // Delete confirmation dialog
                        // echo "<td><a onClick=\"javascript: return confirm('Confirm deletion');\" href='posts.php?delete={$post_id}'>Delete</a></td>";
                        echo "</tr>";
                    }

                    //  Delete CONFIRMATION & HANDLING
                    if (isset($_POST['delete'])) {
                        $delete_id = $_POST['post_id'];
                        $query = "DELETE FROM posts WHERE post_id = {$delete_id}";
                        $delete_query = mysqli_query($connection, $query);
                        header("Location: posts.php");
                    }

                    //  RESET views
                    if (isset($_GET['views_reset'])) {
                        $reset_id = $_GET['views_reset'];

                        $query = "UPDATE posts SET post_views = 0 WHERE post_id = {$reset_id}";
                        $update_query = mysqli_query($connection, $query);
                        header("Location: posts.php");
                    }

                    //  Table end
                    echo '</tbody></table></form>';
                }
            }
            ?>