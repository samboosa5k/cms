<!--  Admin categories page -->

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
                        Welcome to the admin-panel
                        <small>**admin name**</small>
                    </h1>
                    <!-- FORM - add category -->
                    <div class="col-xs-6">

                        <?php
                        //  from FUNCTIONS.php
                        insert_categories();
                        ?>

                        <form action="" method="post" class="">
                            <div class="form-group">
                                <label for="cat-title" class="">Category title</label>
                                <br>
                                <input type="text" name="cat_title" class="">
                            </div>
                            <div class="form-group">
                                <input type="submit" name="submit" class="btn btn-primary" value="Add category">
                            </div>
                        </form>

                        <?php
                        update_cats();
                        ?>

                    </div>

                    <!-- Table of categories -->
                    <div class="col-xs-6">
                        <table class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Category title</th>
                                </tr>
                            </thead>
                            <tbody>

                                <?php
                                //  include & FIND all CATEGORIES
                                find_all_cats();
                                ?>

                                <?php
                                delete_cats();
                                ?>

                            </tbody>
                        </table>
                    </div>

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