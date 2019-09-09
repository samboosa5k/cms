<form action="" method="post" class="">
    <div class="form-group">
        <label for="cat-title" class="">Edit category</label>
        <br>

        <?php
        //  FETCH the category you clicked on to edit, and display it in the text field
        if (isset($_GET['edit'])) {
            $edit_cat_id = $_GET['edit'];
            $query = "SELECT * FROM categories WHERE cat_id = $edit_cat_id";
            $select_cat_id_edit = mysqli_query($connection, $query);

            while ($row = mysqli_fetch_assoc($select_cat_id_edit)) {
                $cat_id = $row['cat_id'];
                $cat_title = $row['cat_title'];

                ?>

        <input value="<?php if (isset($cat_title)) {
                                    echo $cat_title;
                                } ?>" type="text" name="cat_title" class="">
        <?php }
        } ?>

        <?php
        //  UPDATE query
        if (isset($_POST['update_cat'])) {
            $update_cat_title = $_POST['cat_title'];

            $prepare_statement_update = mysqli_prepare($connection, "UPDATE categories SET cat_title='{$update_cat_title}' WHERE cat_id={$cat_id}");

            mysqli_stmt_execute($prepare_statement_update);

            mysqli_stmt_store_result($prepare_statement_update);
            mysqli_stmt_close($prepare_statement_update);
            if (!$prepare_statement_update) {
                die("Updating category failed:" . mysqli_error($connection));
            }
        }
        ?>

    </div>
    <div class="form-group">
        <input type="submit" name="update_cat" class="btn btn-primary" value="Update category">
    </div>
</form>