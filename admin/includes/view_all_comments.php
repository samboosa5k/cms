<?php
//  Refactored and extracted from functions.php
//  ADMIN_comments start
if (isset($_GET['comment_author'])) {
    $comment_author = $_GET['comment_author'];
    $query = "SELECT * FROM comments WHERE comment_author = '$comment_author'";
} else {
    $query = "SELECT * FROM comments";
}

$select_comments = mysqli_query($connection, $query);

?>


<table class="table table-bordered table-hover">
    <thead class="">
        <tr class="">
            <!-- Comments column headers -->
            <th class="">
                Comment ID
            </th>
            <!--<th class="">
                        Comment post ID
                    </th>-->
            <th class="">Comment author</th>
            <th class="">Comment content</th>
            <th class="">Comment e-mail</th>
            <th class="">Comment status</th>
            <th class="">In response to</th>
            <th class="">Comment date</th>
        </tr>
    </thead>

    <tbody class="">

        <?php

        //  Rows with post content
        while ($row = mysqli_fetch_assoc($select_comments)) {
            $comment_id = $row['comment_id'];
            $comment_post_id = $row['comment_post_id'];
            $comment_author = $row['comment_author'];
            $comment_email = $row['comment_email'];
            $comment_content = $row['comment_content'];
            $comment_status = $row['comment_status'];
            $comment_date = $row['comment_date'];

            echo "<tr class=''>";
            echo "<td>{$comment_id}</td>";
            //echo "<td>{$comment_post_id}</td>";
            echo "<td>{$comment_author}</td>";

            //
            echo "<td>{$comment_content}</td>";
            echo "<td>{$comment_email}</td>";
            echo "<td>{$comment_status}</td>";

            //  START - for showing POST RELATED COMMENT
            $query = "SELECT * FROM posts WHERE post_id = {$comment_post_id} ";
            $select_post_id_query = mysqli_query($connection, $query);

            while ($row = mysqli_fetch_assoc($select_post_id_query)) {
                $related_post = $row['post_title'];

                echo "<td><a href='../post.php?p_id=$comment_post_id'>$related_post</a></td>";
            }
            //  END - POST RELATED COMMENT

            echo "<td>{$comment_date}</td>";
            echo "<td><a href='comments.php?approve=1&amp;c_id={$comment_id}'>Approve</a></td>";
            echo "<td><a href='comments.php?approve=0&amp;c_id={$comment_id}'>Reject</a></td>";
            echo "<td><a href='comments.php?delete={$comment_id}'>Delete</a></td>";
            echo "</tr>";
        }

        //  approve/reject HANDLING
        if (isset($_GET['approve'])) {
            $comment_delete_id = $_GET['c_id'];
            $approve_or_reject = $_GET['approve'];

            if ($approve_or_reject == 0) {
                $query = "UPDATE comments SET comment_status='Rejected' WHERE comment_id = {$comment_delete_id}";
            } elseif ($approve_or_reject == 1) {
                $query = "UPDATE comments SET comment_status='Approved' WHERE comment_id = {$comment_delete_id}";
            }

            $approve_or_reject_query = mysqli_query($connection, $query);
            header("Location: comments.php");
        }

        //  Delete CONFIRMATION & HANDLING
        if (isset($_GET['delete'])) {
            $comment_delete_id = $_GET['delete'];

            echo "<h4><a href='comments.php?delete={$comment_delete_id}&amp;confirm=yes'>Confirm delete?</a></h4>";

            if (isset($_GET['confirm'])) {
                $confirm = $_GET['confirm'];

                $query = "DELETE FROM comments WHERE comment_id = {$comment_delete_id}";
                $delete_query = mysqli_query($connection, $query);
                header("Location: comments.php");
            }
        }

        //  Table end
        echo '
            </tbody>
        </table>
        ';

//  ADMIN_COMMENTS end
