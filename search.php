<!-- Connection -->
<?php
include("includes/db.php");
?>

<!-- Header -->
<?php
include("includes/header.php");
?>

<!-- Functions -->
<?php
include("admin/functions.php");
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

            if (isset($_POST['submit'])) {
                $search = escape($_POST['search']);

                //  %$search% = percentage symbol is a wildcard
                //  It returns results either starting or ending anywhere with the contained $search variable(s)
                $query = "SELECT * FROM posts WHERE post_tags LIKE '%$search%' ";

                //  In the 'mysqli_query($link, query)', the $link is the $connection defined in db.php
                $search_query = mysqli_query($connection, $query);

                if (!$search_query) {
                    die("Query failed" . mysqli_error($connection));
                }

                //  Count rows returned from query, in case of no results
                $count = mysqli_num_rows($search_query);

                if ($count == 0) {
                    echo "<p>No results</p>";
                } else {
                    while ($row = mysqli_fetch_assoc($search_query)) {
                        $post_title = $row['post_title'];
                        $post_author = $row['post_author'];
                        $post_date = $row['post_date'];
                        $post_image = $row['post_image'];
                        $post_content = $row['post_content'];

                        //echo "<li><a href='#'>{$cat_title}</a></li>";
                        ?>

            <h1 class="page-header">
                <!-- Page Heading
                <small>Secondary Text</small> -->
            </h1>

            <!-- First Blog Post -->
            <h2>
                <a href="#"><?php echo $post_title; ?></a>
            </h2>
            <p class="lead">
                by <a href="index.php"><?php echo $post_author; ?></a>
            </p>
            <p><span class="glyphicon glyphicon-time"></span> Posted on <?php echo $post_date; ?></p>
            <hr>
            <img class="img-responsive" src="images/<?php echo $post_image; ?>" alt="">
            <hr>
            <p><?php echo $post_content; ?></p>
            <a class="btn btn-primary" href="#">Read More <span class="glyphicon glyphicon-chevron-right"></span></a>

            <hr>

            <?php }
                }
            }
            ?>




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