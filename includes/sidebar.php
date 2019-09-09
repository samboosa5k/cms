<!-- Connection -->
<?php
$connection = mysqli_connect(DB_ADDRESS, DB_USER, DB_PASS, DB_NAME);
?>

<div class="col-md-4">

    <!-- Blog Search Well -->
    <div class="well">
        <h4>Blog Search</h4>
        <!-- Search form -->
        <form action="search.php" method="post">
            <div class="input-group">
                <input name="search" type="text" class="form-control">
                <span class="input-group-btn">
                    <button name="submit" class="btn btn-default" type="submit">
                        <span class="glyphicon glyphicon-search"></span>
                    </button>
                </span>
            </div>
        </form>
        <!-- Search form end -->
    </div>

    <!-- display/hide login box -->
    <?php
    if (!isset($_SESSION['role'])) {
        ?>
    <!-- Login Well -->
    <div class="well">
        <h4>Login</h4>
        <form action="/cms/includes/login.php" method="post">
            <div class="form-group">
                <input name="username" type="text" class="form-control" placeholder="Enter username" autocomplete="on">
            </div>
            <div class="input-group">
                <input name="password" type="password" class="form-control" placeholder="Enter password">
                <span class="input-group-btn">
                    <button class="btn btn-primary" name="login" type="submit">Submit</button>
                </span>
            </div>
        </form>
        <!-- Login end -->
    </div>

    <?php } ?>

    <!-- Blog Categories Well -->
    <div class="well">
        <h4>Blog Categories</h4>

        <?php
        $prep_statement = mysqli_prepare($connection, "SELECT cat_id, cat_title FROM categories");

        if (isset($prep_statement)) {
            $cat_prep_Statement = $prep_statement;

            mysqli_stmt_execute($prep_statement);

            //mysqli_stmt_bind_param($prep_statement, "is", $cat_id, $cat_title);

            mysqli_stmt_bind_result($prep_statement, $cat_id, $cat_title);
        }
        ?>

        <div class="row">
            <div class="col-lg-12">
                <ul class="list-unstyled">

                    <?php while (mysqli_stmt_fetch($prep_statement)) : ?>

                    <li><a href='/cms/category/<?php echo $cat_id; ?>'><?php echo $cat_title; ?></a></li>

                    <?php endwhile; ?>

                </ul>
            </div>
        </div>
        <!-- /.row -->
    </div>

    <!-- Side Widget Well -->
    <?php include "widget.php" ?>

</div>