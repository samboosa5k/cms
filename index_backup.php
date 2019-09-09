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

<!-- Page Content -->
<div class="container">

    <div class="row">

        <!-- Blog Entries Column -->
        <div class="col-md-8">

            <?php

            $query = "SELECT * FROM posts WHERE post_status = 'Published'";
            $select_all_posts = mysqli_query($connection, $query);

            while ($row = mysqli_fetch_assoc($select_all_posts)) {
                $post_id = $row['post_id'];
                $post_title = $row['post_title'];
                $post_author = $row['post_author'];
                $post_date = $row['post_date'];
                $post_image = $row['post_image'];
                $post_content = substr($row['post_content'], 0, 128) . " ...";

                //echo "<li><a href='#'>{$cat_title}</a></li>";
                ?>

                <h1 class="page-header">
                    Page Heading
                    <small>Secondary Text</small>
                </h1>

                <!-- First Blog Post -->
                <h2>
                    <a href='post.php?p_id=<?php echo $post_id; ?>'><?php echo $post_title; ?></a>
                </h2>
                <p class="lead">
                    by <span class="label label-primary"><strong><a style="color:white;" href="author_posts.php?author=<?php echo $post_author; ?>&amp;p_id=<?php echo $post_id; ?>"><?php echo $post_author; ?></a></strong></span>
                </p>
                <div>
                    <?php
                    if (isset($_SESSION['role']) && $_SESSION['role'] == "Admin") {
                        echo "<p class='alert alert-danger' role='alert'><strong><a href='./admin/posts.php?source=edit_posts&edit_id={$post_id}'>Edit post!</a></strong></p>";
                    }
                    ?>
                </div>
                <p><span class="glyphicon glyphicon-time"></span> Posted on <?php echo $post_date; ?></p>
                <hr>
                <a href='post.php?p_id=<?php echo $post_id; ?>'>
                    <img class="img-responsive" src="images/<?php echo $post_image; ?>" alt="">
                </a>
                <hr>
                <p><?php echo $post_content; ?></p>
                <a class="btn btn-primary" href='post.php?p_id=<?php echo $post_id; ?>'>Read More <span class="glyphicon glyphicon-chevron-right"></span></a>

                <hr>

            <?php } ?>

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