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
                    <h1 class="page-header">
                        Welcome to your data:

                        <small><?php echo get_username(); ?></small>
                    </h1>
                </div>
            </div>
            <!-- /.row -->


            <!-- /.row -->
            <div class="row">
                <div class="col-lg-3 col-md-6">
                    <div class="panel panel-primary">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-xs-3">
                                    <i class="fa fa-file-text fa-5x"></i>
                                </div>
                                <div class="col-xs-9 text-right">
                                    <!-- COUNT POSTS -->
                                    <div class='huge'>
                                        <?php
                                        echo count_specific_records('posts', 'post_author', get_username());
                                        ?>
                                    </div>
                                    <div>Posts</div>
                                </div>
                            </div>
                        </div>
                        <a href="posts.php?author=<?php echo get_username(); ?>">
                            <div class="panel-footer">
                                <span class="pull-left">View your posts</span>
                                <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                <div class="clearfix"></div>
                            </div>
                        </a>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="panel panel-green">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-xs-3">
                                    <i class="fa fa-comments fa-5x"></i>
                                </div>
                                <div class="col-xs-9 text-right">
                                    <!-- COUNT COMMENTS -->
                                    <div class='huge'>
                                        <?php
                                        echo count_specific_records('comments', 'comment_author', get_username());
                                        ?>
                                    </div>
                                    <div>Comments</div>
                                </div>
                            </div>
                        </div>
                        <a href="comments.php?comment_author=<?php echo get_username(); ?>">
                            <div class="panel-footer">
                                <span class="pull-left">View your comments</span>
                                <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                <div class="clearfix"></div>
                            </div>
                        </a>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-xs-3">
                                    <i class="fa fa-user fa-5x"></i>
                                </div>
                                <div class="col-xs-9 text-right">
                                    <!-- COUNT USERS -->
                                    <div class='huge'>
                                        <?php
                                        echo "x";
                                        ?>
                                    </div>
                                    <div> Pending removal</div>
                                </div>
                            </div>
                        </div>
                        <a href="users.php">
                            <div class="panel-footer">
                                <span class="pull-left">View Details</span>
                                <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                <div class="clearfix"></div>
                            </div>
                        </a>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-xs-3">
                                    <i class="fa fa-list fa-5x"></i>
                                </div>
                                <div class="col-xs-9 text-right">
                                    <div class='huge'>
                                        <?php
                                        echo "x";
                                        ?>
                                    </div>
                                    <div> Pending removal</div>
                                </div>
                            </div>
                        </div>
                        <a href="categories.php">
                            <div class="panel-footer">
                                <span class="pull-left">View Details</span>
                                <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                <div class="clearfix"></div>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
            <!-- /.row -->

            <!-- POST COUNTING - exclusive for graph -->
            <?php
            $post_published_count = count_specific_records('posts', 'post_status', 'Published');
            ?>

            <?php
            $post_draft_count = count_specific_records('posts', 'post_status', 'Draft');
            ?>

            <div class="row">

            </div>

        </div>
        <!-- /.container-fluid -->

    </div>
    <!-- /#page-wrapper -->

    <!-- Include footer -->
    <?php
    include("includes/admin_footer.php");
    ?>

    <script src="/cms/js/pusher.js"></script>

    <!-- Listen for pusher new_user event, then send message to console -->
    <script>
        var pusher = new Pusher('12be849351f1fb942adf', {
            cluster: 'eu',
            forceTLS: true
        });

        var notificationChannel = pusher.subscribe('notifications');

        notificationChannel.bind('new_user', function(notification) {
            var message = notification.message;
            console.log(message);
        });
    </script>