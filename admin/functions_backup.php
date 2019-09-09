<?php

//  Security function Start
//  Use this whenever data is going to sql/database

function escape($string)
{
    global $connection;
    return mysqli_real_escape_string($connection, trim($string));
}

//  Security function end


//  ADMIN_CATEGORIES start

function insert_categories()
{
    global $connection;

    if (isset($_POST['submit'])) {
        $cat_title = $_POST['cat_title'];
        if ($cat_title == "" || empty($cat_title)) {
            echo "This field should not be empty :)";
        } else {
            $query = "INSERT INTO categories(cat_title) VALUE('{$cat_title}')";
            $create_category_query = mysqli_query($connection, $query);

            if (!$create_category_query) {
                die("Query failed :(" . mysqli_error($connection));
            }
        }
    }
}

function find_all_cats()
{
    global $connection;

    $query = "SELECT * FROM categories";
    $select_cat = mysqli_query($connection, $query);
    while ($row = mysqli_fetch_assoc($select_cat)) {
        $cat_id = $row['cat_id'];
        $cat_title = $row['cat_title'];

        echo "<tr>";
        echo "<td>{$cat_id}</td>";
        echo "<td>{$cat_title}</td>";
        echo "<td><a href='categories.php?delete={$cat_id}'>Delete</a></td>";
        echo "<td><a href='categories.php?edit={$cat_id}'>Edit</a></td>";
        echo "</tr>";
    }
}

function update_cats()
{
    //  Checks if EDIT has been triggered and parameter has been sent to URL
    //  Then the update field & button will be included and displayed

    global $connection;

    if (isset($_GET['edit'])) {
        $cat_id = $_GET['edit'];
        include("includes/update_categories.php");
    }
}

function delete_cats()
{
    global $connection;

    if (isset($_GET['delete'])) {
        $delete_cat_id = $_GET['delete'];
        $query = "DELETE FROM categories WHERE cat_id={$delete_cat_id}";
        $delete_query = mysqli_query($connection, $query);
        //  "header" sends a raw(?) HTTP header to the client --> refreshing
        header("Location: categories.php");
    }
}

//  ADMIN CATEGORIES end


//  ADMIN_POSTS start

//  Function is extremely long, how to fix this?
//  --> This function can be REFACTORED to the POSTS.php page

function handle_all_posts()
{
    global $connection;

    if (isset($_GET['source'])) {
        $source = $_GET['source'];

        switch ($source) {
            case ("test"):
                echo "<h1>Test source</h1>";
                break;

            case ("add_posts");
                include("includes/add_posts.php");
                break;

            case ("edit_posts");
                include("includes/edit_posts.php");
                break;
        }
    } else {
        //  If no specific post operation is selected, display ALL
        $query = "SELECT * FROM posts";
        $select_post = mysqli_query($connection, $query);

        //  Post column content (UNDER headers)
        //  Table start

        if (isset($_POST['checkboxArray'])) {
            //
        }

        echo '
        <form action="" method="post">
            <table class="table table-bordered table-hover">
                <div id="bulkOptionsContainer" class="col-xs-4">
                    <select class="form-control">
                        <option>- Select option -</option>
                        <option>Publish</option>
                        <option>Draft</option>
                        <option>Delete</option>
                    </select>
                </div>

                <div class="col-xs-4">
                    <input type="submit" name="submit" class="btn btn-success" value="Apply">
                    <a class="btn btn-primary" href="add_post.php">Add post</a>
                </div>

                <br>
                <thead>
                    <tr>
                        <!-- Posts column headers -->
                        <th><input type="checkbox"></th>
                        <th>ID</th>
                        <th>Author</th>
                        <th>Title</th>
                        <th>Category</th>
                        <th>Status</th>
                        <th>Image</th>
                        <th>Tags</th>
                        <th>Comments</th>
                        <th>Date</th>
                    </tr>
                </thead>

                <tbody>
        ';

        //  Rows with post content
        while ($row = mysqli_fetch_assoc($select_post)) {
            $post_id = $row['post_id'];
            $post_author = $row['post_author'];
            $post_title = $row['post_title'];
            $post_category_id = $row['post_category_id'];
            $post_status = $row['post_status'];
            $post_image = $row['post_image'];
            $post_tags = $row['post_tags'];
            $post_comment_count = $row['post_comment_count'];
            $post_date = $row['post_date'];

            echo "<tr>";
            ?>

<td><input class='checkboxes' type='checkbox' name='checkboxArray[]' value='<?php $post_id; ?>'></td>;

<?php
            echo "<td>{$post_id}</td>";
            echo "<td>{$post_author}</td>";
            echo "<td>{$post_title}</td>";

            //  display CATEGORY
            $query = "SELECT * FROM categories WHERE cat_id = $post_category_id";
            $display_category = mysqli_query($connection, $query);

            while ($row = mysqli_fetch_assoc($display_category)) {
                $cat_id = $row['cat_id'];
                $cat_title = $row['cat_title'];
                echo "<td>{$cat_title}</td>";
            }

            //
            echo "<td>{$post_status}</td>";
            echo "<td><a href='../images/{$post_image}'>{$post_image}</a></td>";
            echo "<td>{$post_tags}</td>";
            echo "<td>{$post_comment_count}</td>";
            echo "<td>{$post_date}</td>";
            echo "<td><a href='posts.php?source=edit_posts&amp;edit_id={$post_id}'>Edit</a></td>";
            echo "<td><a href='posts.php?delete={$post_id}'>Delete</a></td>";
            echo "</tr>";
        }

        //  Delete CONFIRMATION & HANDLING
        if (isset($_GET['delete'])) {
            $delete_id = $_GET['delete'];

            echo "<h4><a href='posts.php?delete={$delete_id}&amp;confirm=yes'>Confirm delete?</a></h4>";

            if (isset($_GET['confirm'])) {
                $confirm = $_GET['confirm'];

                $query = "DELETE FROM posts WHERE post_id = {$delete_id}";
                $delete_query = mysqli_query($connection, $query);
                header("Location: posts.php");
            }
        }

        //  Table end
        echo '
            </tbody>
        </table>
        </form>
        ';
    }
}

//  ADMIN_POSTS end


//  USERS ONLINE start

function users_online()
{
    global $connection;
    //  Session parameters
    $session = session_id();
    $time = time();
    $time_out_seconds = 60;
    $time_out_counter = $time - $time_out_seconds;

    //  Users session query
    $query = "SELECT * FROM users_online WHERE session = '$session'";
    $session_online_query = mysqli_query($connection, $query);
    $count_rows_users_online = mysqli_num_rows($session_online_query);

    //  Insert into users_online table
    if ($count_rows_users_online == NULL) {
        mysqli_query($connection, "INSERT INTO users_online(session, time) VALUES('$session', '$time')");
    } else {
        mysqli_query($connection, "UPDATE users_online SET time = '$time' WHERE session = '$session'");
    }

    //
    $user_online_query = mysqli_query($connection, "SELECT * FROM users_online WHERE time > '$time_out_counter'");
    $user_online_query_count = mysqli_num_rows($user_online_query);

    echo $user_online_query_count;
}

//  USERS ONLINE end
