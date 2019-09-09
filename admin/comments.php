<!--  Admin comments page -->

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
                    <?php if (isset($_GET['comment_author'])) {
                        $comments_author = $_GET['comment_author'];
                        ?>
                    <h1 class="page-header">
                        Comments by <?php echo $comments_author; ?>
                    </h1>
                    <?php } else { ?>
                    <h1 class="page-header">
                        Welcome to the comments page!
                    </h1>
                    <?php } ?>

                    <?php
                    include("includes/view_all_comments.php");
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