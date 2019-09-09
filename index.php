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

            //  COUNT posts & LIMIT rows from displaying based on $_GET['page']
            $all_posts = "SELECT * FROM posts ";

            //  get ALL POSTS if Admin
            if (!is_admin()) {
                $all_posts .= "WHERE post_status = 'Published'";
            } else {
                $all_posts .= "";
            }

            $paginate_count_posts = ceil(mysqli_num_rows(mysqli_query($connection, $all_posts)) / 4);
            $count_published_posts = mysqli_num_rows(mysqli_query($connection, $all_posts));

            //  Select paginated page
            if (isset($_GET['page'])) {
                $page = $_GET['page'];
            } else {
                $page = "";
            }

            //  Generate limit for pagination
            if ($page == "" || $page == "1") {
                $page_1 = 0;
            } else {
                $page_1 = ($page * 4) - 4;
            }

            //  start - IF THERE ARE POSTS
            if ($count_published_posts > 0) {
                $query = "SELECT * FROM posts ";
                //  get ALL POSTS if Admin
                if (!is_admin()) {
                    $query .= "WHERE post_status = 'Published' ";
                }
                $query .= "ORDER BY post_id DESC LIMIT {$page_1},4";
                $select_all_posts = mysqli_query($connection, $query);

                while ($row = mysqli_fetch_assoc($select_all_posts)) {
                    $post_id = $row['post_id'];
                    $post_title = $row['post_title'];
                    $post_author = $row['post_author'];
                    $post_date = $row['post_date'];
                    $post_image = $row['post_image'];
                    $post_content = substr($row['post_content'], 0, 128) . " ...";
                    $post_status = $row['post_status'];

                    //echo "<li><a href='#'>{$cat_title}</a></li>";
                    ?>

            <!-- First Blog Post -->
            <h2>
                <a href='post/<?php echo $post_id; ?>'><?php echo $post_title; ?></a>
                <?php
                        if (is_admin()) {
                            echo "<span class='label label-primary' style='font-size: 12px;'>'$post_status'</span>";
                        }
                        ?>
            </h2>
            <p class="lead">
                by <span class="label label-info"><strong><a style="color:white;" href="author_posts.php?author=<?php echo $post_author; ?>&amp;p_id=<?php echo $post_id; ?>"><?php echo $post_author; ?></a></strong></span>
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
            <a href='post/<?php echo $post_id; ?>'>
                <img class="img-responsive" src="/cms/images/<?php echo $post_image; ?>" alt="">
            </a>
            <hr>
            <p><?php echo $post_content; ?></p>
            <a class="btn btn-primary" href='post.php?p_id=<?php echo $post_id; ?>'>Read More <span class="glyphicon glyphicon-chevron-right"></span></a>

            <hr>
            <div class="row">
                <p class="pull-right"><span class="glyphicon glyphicon-fire"></span><a href=""> Like </a><span>69</span></p>
            </div>

            <?php
                    //  end - IF THERE ARE POSTS
                }
            } else {
                echo "<h1 class='text-center'>No posts are published!</h1>";
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
    <ul class="pager">
        <!-- GENERATE pagination numbers -->
        <?php
        for ($i = 1; $i <= $paginate_count_posts; $i++) {
            if ($i == $page) {
                echo "<li class='badge badge-pill badge-info><a href='?page={$i}'>$i</a></li>";
            } else {
                echo "<li><a href='?page={$i}'>$i</a></li>";
            }
        }
        ?>
    </ul>

    <?php
    include "includes/footer.php";
    ?>