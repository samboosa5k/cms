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

            if (isset($_GET['cat'])) {
                //
                $post_category_id = $_GET['cat'];
                $published = 'Published';

                //  SELECT posts related to selected category, and only show Published posts IF_ADMIN
                if (is_admin()) {
                    $prep_statement_1 = mysqli_prepare($connection, "SELECT post_id, post_title, post_author, post_date, post_image, post_content FROM posts WHERE post_category_id = '$post_category_id'");
                } else {

                    $prep_statement_2 = mysqli_prepare($connection, "SELECT post_id, post_title, post_author, post_date, post_image, post_content FROM posts WHERE post_category_id = $post_category_id AND post_status = '$published'");
                }

                //$select_all_posts = mysqli_query($connection, $query);

                if (isset($prep_statement_1)) {
                    mysqli_stmt_execute($prep_statement_1);

                    mysqli_stmt_store_result($prep_statement_1);

                    mysqli_stmt_bind_result($prep_statement_1, $post_id, $post_title, $post_author, $post_date, $post_image, $post_content);

                    $which_prep_statement = $prep_statement_1;
                } else {
                    mysqli_stmt_execute($prep_statement_2);

                    mysqli_stmt_store_result($prep_statement_2);

                    mysqli_stmt_bind_result($prep_statement_2, $post_id, $post_title, $post_author, $post_date, $post_image, $post_content);

                    $which_prep_statement = $prep_statement_2;
                }


                $count_cat_posts = mysqli_stmt_num_rows($which_prep_statement);


                if ($count_cat_posts > 0) {


                    while (mysqli_stmt_fetch($which_prep_statement)) :
                        ?>

            <!-- First Blog Post -->
            <h2>
                <a href='post.php?p_id=<?php echo $post_id; ?>'><?php echo $post_title; ?></a>
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

            <?php

                    endwhile;
                    mysqli_stmt_close($which_prep_statement);
                } elseif ($count_cat_posts === 0) {
                    echo "<h1 class='text-center'>No category related posts!</h1>";
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