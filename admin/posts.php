<!--  Admin posts page -->

<!-- Include header -->
<?php
include("includes/admin_header.php");
?>

<div id="wrapper">

    <!-- Navigation -->
    <?php include("includes/admin_navigation.php"); ?>

    <div id="page-wrapper">

        <div class="container-fluid">

            <!-- Page Heading -->
            <div class="row">
                <div class="col-lg-12">
                    <?php if (isset($_GET['author'])) {
                        $author = $_GET['author'];
                        ?>
                    <h1 class="page-header">
                        Posts by <?php echo $author; ?>
                    </h1>
                    <?php } else { ?>
                    <h1 class="page-header">
                        Welcome to the posts page!
                    </h1>
                    <?php } ?>

                    <?php
                    //  include & FIND all POSTS (if source is correct)
                    //  if source = add_posts, display the add posts form
                    //  handle_all_posts();
                    include("includes/view_all_posts.php");
                    ?>
                </div>
            </div>
            <!-- /.row -->

        </div>
        <!-- /.container-fluid -->

    </div>
    <!-- /#page-wrapper -->

    <!-- Include footer -->
    <?php
    include("includes/admin_footer.php");
    ?>