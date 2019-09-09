<!-- Connection -->
<?php
include("includes/db.php");
?>

<!-- Header -->
<?php
include("includes/header.php");
?>

<!-- Navigation -->
<?php
include("includes/navigation.php");
?>

<!-- AJAX LIKING via POST -->
<?php
if (isset($_POST['liked'])) {
    //  Below variable values are caught from the AJAX request
    $post_id = $_POST['post_id'];
    $user_id = $_POST['user_id'];

    //  1. Select posts
    $query = "SELECT * FROM posts WHERE post_id = $post_id";
    $select_query = mysqli_query($connection, $query);
    $result = mysqli_fetch_array($select_query);
    $likes = $result['post_likes'];

    if (mysqli_num_rows($select_query) >= 1) {
        echo $result['post_id'];
    }

    //  2. update posts

    mysqli_query($connection, "UPDATE posts SET post_likes=$likes+1 WHERE post_id=$post_id");

    //  3. insert likes --> LIKES table

    mysqli_query($connection, "INSERT INTO likes(user_id, post_id) VALUES($user_id, $post_id)");

    exit();

    //

    if (!$select_query) {
        die("Fail query" . mysqli_error($select_query));
    }
};
?>

<!-- AJAX un-LIKING via POST -->
<?php
if (isset($_POST['unliked'])) {

    echo "UNLIKED";

    //  Below variable values are caught from the AJAX request
    $post_id = $_POST['post_id'];
    $user_id = $_POST['user_id'];


    //  1. Fetching post
    $query = "SELECT * FROM posts WHERE post_id = $post_id";
    $select_query = mysqli_query($connection, $query);
    $result = mysqli_fetch_array($select_query);
    $likes = $result['post_likes'];

    if (mysqli_num_rows($select_query) >= 1) {
        echo $result['post_id'];
    }

    //  2. Delete likes
    mysqli_query($connection, "DELETE FROM likes WHERE post_id=$post_id AND user_id=$user_id");

    //  3. Update/Decrement likes

    mysqli_query($connection, "UPDATE posts SET post_likes=$likes-1 WHERE post_id=$post_id");
};
?>

<!-- Page Content -->
<div class="container">

    <div class="row">

        <!-- Blog Entries Column -->
        <div class="col-md-8">

            <?php

            if (isset($_GET['p_id'])) {
                //
                $post_page_id = $_GET['p_id'];

                //  UPDATE VIEW COUNT
                $query = "UPDATE posts SET post_views = post_views+1 WHERE post_id = {$post_page_id}";
                $update_post_views_query = mysqli_query($connection, $query);

                //  SELECT SPECIFIC POST
                $query = "SELECT * FROM posts WHERE post_id = $post_page_id ";
                //  ONLY display published post if NOT admin
                /* if (is_admin() == false) {
                    $query .= "WHERE post_status = 'Published' ";
                } else {
                    $query .= "";
                } */

                $select_all_posts = mysqli_query($connection, $query);

                if ($select_all_posts) {

                    while ($row = mysqli_fetch_assoc($select_all_posts)) {
                        $post_id = $row['post_id'];
                        $post_title = $row['post_title'];
                        $post_author = $row['post_author'];
                        $post_date = $row['post_date'];
                        $post_image = $row['post_image'];
                        $post_content = $row['post_content'];
                        $post_status = $row['post_status'];

                        if (!is_admin() && $post_status == 'Draft') {
                            echo "<h1 class='text-center'>This post is not published yet!</h1>";
                            /* sleep(5); */
                            header("Location: index.php");
                        }



                        //echo "<li><a href='#'>{$cat_title}</a></li>";
                        ?>


            <!-- First Blog Post -->
            <h2>
                <a href="/cms/post/<?php echo $post_id; ?>"><?php echo $post_title; ?></a>
            </h2>
            <p class="lead">
                by <a href="index.php"><?php echo $post_author; ?></a>
                <br>
                <h1>Liked:<?php if (already_liked($_GET['p_id'])) {
                                            echo "Yes!";
                                        } else {
                                            echo "No!";
                                        }
                                        ?></h1>
            </p>
            <div>
                <?php
                            if (is_admin()) {
                                echo "<p class='alert alert-danger' role='alert'><strong><a href='./admin/posts.php?source=edit_posts&edit_id={$post_id}'>Edit post!</a></strong></p>";
                            }


                            ?>
            </div>
            <p><span class="glyphicon glyphicon-time"></span> Posted on <?php echo $post_date; ?></p>
            <hr>
            <img class="img-responsive" src="/cms/images/<?php echo $post_image; ?>" alt="">
            <hr>
            <p><?php echo $post_content; ?></p>

            <hr>

            <?php
                        if (!already_liked($post_page_id)) {
                            ?>
            <div class="row" id="like-parent">
                <p class="pull-right"><span class="glyphicon glyphicon-fire"></span><a href="" class="like" onclick="likePost();"> Like </a></p>
            </div>
            <?php
                        } else {
                            ?>
            <div class="row" id="unlike-parent">
                <p class="pull-right"><span class="glyphicon glyphicon-chevron-down"></span><a href="" class="unlike" onclick="unlikePost();"> Unlike </a></p>
            </div>
            <?php
                        } ?>

            <div class="row" id="">
                <p class="pull-right">Likes: <span>

                        <?php
                                    echo count_specific_records('likes', 'post_id', $post_page_id);
                                    ?>
                    </span></p>
            </div>

            <?php

                    }
                } /* elseif ($post_status == 'Draft' || $post_status == 'draft') {
                    echo "<h1 class='text-center'>This post is not published yet!</h1>";
                } */
            }
            ?>

            <!-- Blog Comments -->

            <?php
            if ($select_all_posts) {
                if (isset($_POST['submit_comment'])) {
                    $post_page_id = $_GET['p_id'];
                    $comment_author = $_POST['comment_author'];
                    $comment_email = $_POST['comment_email'];
                    $comment_content = $_POST['comment_content'];
                    if (!empty($comment_author) && !empty($comment_email) && !empty($comment_content)) {
                        //
                        $query = "INSERT INTO comments(comment_post_id, comment_author, comment_email, comment_content, comment_status, comment_date) ";
                        $query .= "VALUES($post_page_id,'{$comment_author}','{$comment_email}','{$comment_content}','Pending', now())";
                        $submit_comment_query = mysqli_query($connection, $query);

                        if (!$submit_comment_query) {
                            die("Submit comment failed! " . mysqli_error($connection));
                        }

                        //  INCREMENT post count
                        /* $query = "UPDATE posts SET post_comment_count = post_comment_count + 1 ";
                    $query .= "WHERE post_id = $post_page_id "; */

                        $update_comment_count = $submit_comment_query = mysqli_query($connection, $query);
                    } else {
                        echo "<div class='alert alert-success'><p>Fields can not be empty!</p></div>";
                    }
                }
            }
            ?>

            <?php
            if ($select_all_posts) {
                ?>
            <!-- Comments Form -->
            <div class="well">
                <h4>Leave a Comment:</h4>
                <form role="form" action="" method="post">
                    <div class="form-group">
                        <label for="Author" class="">Name</label>
                        <input type="text" class="form-control" name="comment_author">
                    </div>
                    <div class="form-group">
                        <label for="E-mail" class="">E-mail</label>
                        <input type="email" class="form-control" name="comment_email">
                    </div>
                    <div class="form-group">
                        <label for="Comment" class="">Your comment</label>
                        <textarea class="form-control" name="comment_content" rows="3"></textarea>
                    </div>
                    <button type="submit" name="submit_comment" class="btn btn-primary">Submit</button>
                </form>
            </div>

            <hr>
            <?php } ?>

            <!-- Posted Comments -->

            <?php

            if ($select_all_posts) {

                $query = "SELECT * FROM comments WHERE comment_post_id = {$post_page_id} AND comment_status = 'Approved' ";
                $query .= "ORDER BY comment_id DESC ";
                $select_comment_query = mysqli_query($connection, $query);

                if (!$select_comment_query) {
                    die("Showing comments failed: " . mysqli_error($connection));
                }

                while ($row = mysqli_fetch_assoc($select_comment_query)) {
                    $comment_author = $row['comment_author'];
                    $comment_date = $row['comment_date'];
                    $comment_content = $row['comment_content'];

                    ?>

            <!-- Comment -->
            <div class="media">
                <a class="pull-left" href="#">
                    <img class="media-object" src="http://placehold.it/64x64" alt="">
                </a>
                <div class="media-body">
                    <h4 class="media-heading"><?php echo $comment_author; ?>
                        <small><?php echo $comment_date; ?></small>
                    </h4>
                    <?php echo $comment_content; ?>
                </div>
            </div>

            <?php }
            } ?>


        </div>

        <!-- Blog Sidebar Widgets Column -->
        <?php
        include "includes/sidebar.php";
        ?>

    </div>
    <!-- /.row -->

    <hr>

    <?php
    include "includes/footer.php";
    ?>

    <!-- 
    Vanilla JS version of jquery-ajax requesting
    Did not want to use jquery as in lecture 319
    Source:

    https://developer.mozilla.org/en-US/docs/Web/API/XMLHttpRequest/responseURL
 -->
    <script>
        var post_id = <?php echo $post_page_id; ?>;
        var user_id = <?php echo $_SESSION['user_id']; ?>;
        var request = new XMLHttpRequest();

        function likePost() {
            request.open('POST', `/cms/post.php?p_id=${post_id}`, true);
            // setRequestHeader is essential otherwise $_POST won't pick it up
            request.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
            request.onload = function() {
                console.log(`Liked post ID -> ${post_id}`);
            };
            request.send(`post_id=${post_id}&liked=1&user_id=${user_id}`);
        }

        function unlikePost() {
            request.open('POST', `/cms/post.php?p_id=${post_id}`, true);
            // setRequestHeader is essential otherwise $_POST won't pick it up
            request.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
            request.onload = function() {
                console.log(`Unliked post ID -> ${post_id}`);
            };
            request.send(`post_id=${post_id}&unliked=1&user_id=${user_id}`);
        }
    </script>