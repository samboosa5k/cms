<?php
//  Refactored and extracted from functions.php
//  ADMIN_users start

$query = "SELECT * FROM users";
$select_users = mysqli_query($connection, $query);

?>

<table class="table table-bordered table-hover">
    <thead class="">
        <tr class="">
            <!-- users column headers -->
            <th class="">ID</th>
            <th class="">Username</th>
            <th class="">Firstname</th>
            <th class="">Lastname</th>
            <th class="">Email</th>
            <th class="">Role</th>
            <th class="">Date</th>
        </tr>
    </thead>

    <tbody class="">

        <?php

        //  Rows with post content
        while ($row = mysqli_fetch_assoc($select_users)) {
            $user_id = $row['user_id'];
            $username = $row['username'];
            $user_firstname = $row['user_firstname'];
            $user_lastname = $row['user_lastname'];
            $user_email = $row['user_email'];
            $user_role = $row['user_role'];
            $user_date = (empty($row['user_date'])) ? "no date set" : $row['user_date'];

            echo "<tr class=''>";
            echo "<td>{$user_id}</td>";
            echo "<td>{$username}</td>";
            echo "<td>{$user_firstname}</td>";
            echo "<td>{$user_lastname}</td>";

            //
            echo "<td>{$user_email}</td>";
            echo "<td>{$user_role}</td>";
            echo "<td>{$user_date}</td>";

            //  custom MODIFICATION links
            echo "<td><a href='users.php?changeRole=1&amp;user_id={$user_id}'>Promote</a></td>";
            echo "<td><a href='users.php?changeRole=0&amp;user_id={$user_id}'>Demote</a></td>";
            echo "<td><a href='users.php?source=edit_user&amp;user_id={$user_id}'>Edit</a></td>";
            echo "<td><a href='users.php?delete={$user_id}'>Delete</a></td>";
            echo "</tr>";
        }

        //  approve/reject HANDLING
        if (isset($_GET['changeRole'])) {
            $user_changeRole_id = $_GET['user_id'];
            $promote_or_demote = $_GET['changeRole'];

            if ($promote_or_demote == 0) {
                $query = "UPDATE users SET user_role='Standard' WHERE user_id = {$user_changeRole_id}";
            } elseif ($promote_or_demote == 1) {
                $query = "UPDATE users SET user_role='Admin' WHERE user_id = {$user_changeRole_id}";
            }

            $promote_or_demote_query = mysqli_query($connection, $query);
            header("Location: users.php");
        }

        //  Delete CONFIRMATION & HANDLING
        if (isset($_GET['delete'])) {
            if (isset($_SESSION['role']) && $_SESSION['role'] == 'Admin') {
                /* if ($_SESSION['role'] == 'Admin') { */
                $user_delete_id = $_GET['delete'];
                echo "<div class='col-xs-12 text-center'><h4><a class='alert alert-danger' href='users.php?delete={$user_delete_id}&amp;confirm=yes'>Confirm delete?</a></h4></div>";
                if (isset($_GET['confirm'])) {
                    $confirm = $_GET['confirm'];
                    $query = "DELETE FROM users WHERE user_id = {$user_delete_id}";
                    $delete_query = mysqli_query($connection, $query);
                    header("Location: users.php");
                }
                /* } */
            }
        }

        //  Table end
        echo '
            </tbody>
        </table>
        ';

//  ADMIN_users end
