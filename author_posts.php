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

            if (isset($_GET['p_id'])) {
                //
                $post_page_id = $_GET['p_id'];
                $post_page_author = $_GET['author'];
            }

            $query = "SELECT * FROM posts WHERE post_author = '{$post_page_author}' ";
            $select_all_posts = mysqli_query($connection, $query);

            while ($row = mysqli_fetch_assoc($select_all_posts)) {
                $post_id = $row['post_id'];
                $post_title = $row['post_title'];
                $post_author = $row['post_author'];
                $post_date = $row['post_date'];
                $post_image = $row['post_image'];
                $post_content = $row['post_content'];

                //echo "<li><a href='#'>{$cat_title}</a></li>";
                ?>

                <h1 class="page-header">
                    Page Heading
                    <small>Secondary Text</small>
                </h1>

                <!-- First Blog Post -->
                <h2>
                    <a href="post.php?p_id=<?php echo $post_id; ?>"><?php echo $post_title; ?></a>
                </h2>
                <p class="lead">
                    All posts by <span class="label label-primary"><strong><?php echo $post_author; ?></strong></span>
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
                <img class="img-responsive" src="images/<?php echo $post_image; ?>" alt="">
                <hr>
                <p><?php echo $post_content; ?></p>

                <hr>

            <?php } ?>

            <!-- Blog Comments REMOVED-->

            <!-- Comments Form REMOVED-->

            <!-- Posted Comments REMOVED-->

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