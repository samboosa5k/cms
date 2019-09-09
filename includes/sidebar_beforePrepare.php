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
        <form action="includes/login.php" method="post">
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
        $query = "SELECT * FROM categories";
        $select_cat_sidebar = mysqli_query($connection, $query);
        ?>

        <div class="row">
            <div class="col-lg-12">
                <ul class="list-unstyled">

                    <?php
                    while ($row = mysqli_fetch_assoc($select_cat_sidebar)) {
                        $cat_title = $row['cat_title'];
                        $cat_id = $row['cat_id'];
                        echo "<li><a href='category.php?cat=$cat_id'>{$cat_title}</a></li>";
                    }
                    ?>

                </ul>
            </div>
        </div>
        <!-- /.row -->
    </div>

    <!-- Side Widget Well -->
    <?php include "widget.php" ?>

</div>