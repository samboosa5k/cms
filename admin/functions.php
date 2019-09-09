<?php

/* 
#############################################
#   DATABASE FUNCTIONS                      #
#############################################
*/

//  Query helper
function query($query)
{
    global $connection;
    return mysqli_query($connection, $query);
}

//  Count table/records start
function count_records($table)
{
    global $connection;
    $query = "SELECT * FROM " . $table;
    $select_table = mysqli_query($connection, $query);

    $result = mysqli_num_rows($select_table);
    return $result;
}

//  Count table/records end

//  GRAPH - count table/records start

function count_specific_records($table, $column, $condition)
{
    global $connection;
    $query = "SELECT * FROM " . $table . " ";
    $query .= "WHERE " . $column . " = '$condition'";
    $select_specific = mysqli_query($connection, $query);

    $result = mysqli_num_rows($select_specific);
    return $result;
}

//  GRAPH - count table/records end

/* 
#############################################
#   SECURITY FUNCTIONS                      #
#############################################
*/

//  Use this whenever data is going to sql/database

function escape($string)
{
    global $connection;
    return mysqli_real_escape_string($connection, trim($string));
}

//  Security function end

//  LOGIN-CHECK function Start

function is_logged_in()
{
    if (isset($_SESSION['role'])) {
        return true;
    }
}

//  LOGIN-CHECK function end

//  ADMIN-CHECK function Start

function is_admin()
{
    if (is_logged_in()) {
        if ($_SESSION['role'] == 'Admin') {
            return true;
        } else {
            return false;
        }
    }
}

//  ADMIN-CHECK function end

/* 
#############################################
#   FRONT-END/WEBSITE FUNCTIONS             #
#############################################
*/

// already LIKED start

function already_liked($post_id = '')
{
    global $connection;
    $user_id = $_SESSION['user_id'];

    $query = "SELECT * FROM likes WHERE user_id=$user_id AND post_id=$post_id";
    $select_already_liked = mysqli_query($connection, $query);
    //  COUNT AND RETURN TRUE or FALSE
    $result = mysqli_num_rows($select_already_liked);
    if ($result > 0) {
        return true;
    } else {
        return false;
    }
}

// already LIKED end

/* 
#############################################
#   REGISTRATION & ACCOUNT FUNCTIONS        #
#############################################
*/

//  GET USERNAME
function get_username()
{
    return $_SESSION['username'];
}

//  REGISTRATION
function user_registration($username, $user_email, $user_password)
{
    global $connection;

    //  VALIDATION
    if (empty($username) || empty($user_email) || empty($user_password)) {
        return "Fields can NOT be empty!";
    } else if (strlen($username) < 4) {
        return "Username must be > 4 characters";
    } else if (username_exists($username)) {
        return "Username already exists!";
    } else if (email_exists($user_email)) {
        return "Email already registered!";
    }
    //  REGISTRATION process
    else if (!username_exists($username) && !email_exists($user_email)) {
        $user_password = password_hash($user_password, PASSWORD_DEFAULT);

        //  Adding user to db
        $query = "INSERT INTO users(username, user_email, user_password, user_role, user_date) ";
        $query .= "VALUES('{$username}','{$user_email}','{$user_password}','Standard', now())";
        $insert_newUser_query = mysqli_query($connection, $query);

        return "User has been created!";

        if (!$insert_newUser_query) {
            die("Inserting new user failed. Error code == " . mysqli_error($connection));
        }
    }
}


//  REGISTRATION USERNAME-EXISTS function Start
function username_exists($reg_user)
{
    global $connection;
    $query = "SELECT * FROM users WHERE username = '$reg_user'";
    $select_user = mysqli_query($connection, $query);
    $count = mysqli_num_rows($select_user);

    if ($count > 0) {
        return true;
    } else {
        return false;
    }
}

//  REGISTRATION USERNAME-EXISTS function end

//  REGISTRATION EMAIL-EXISTS function Start
function email_exists($reg_email)
{
    global $connection;
    $query = "SELECT * FROM users WHERE user_email = '$reg_email'";
    $select_user = mysqli_query($connection, $query);
    $count = mysqli_num_rows($select_user);

    if ($count > 0) {
        return true;
    } else {
        return false;
    }
}

//  REGISTRATION EMAIL-EXISTS function end

//  LOGIN
function login_try($username, $password)
{
    global $connection;
    $username = escape($_POST['username']);
    $password = escape($_POST['password']);

    $query = "SELECT * FROM users WHERE username = '{$username}'";
    $select_user_query = mysqli_query($connection, $query);

    if (!$select_user_query) {
        die("Login failed?" . mysqli_error($connection));
    }

    while ($row = mysqli_fetch_array($select_user_query)) {
        $db_user_id = $row['user_id'];
        $db_username = $row['username'];
        $db_password = $row['user_password'];
        $db_firstname = $row['user_firstname'];
        $db_lastname = $row['user_lastname'];
        $db_role = $row['user_role'];
    }

    if (password_verify($password, $db_password)) {
        $_SESSION['user_id'] = $db_user_id;
        $_SESSION['username'] = $db_username;
        $_SESSION['firstname'] = $db_firstname;
        $_SESSION['lastname'] = $db_lastname;
        $_SESSION['role'] = $db_role;
        header("Location: ../admin/index.php");
    } else {
        header("Location: ../index.php");
    }
}


/* 
#############################################
#   ADMIN-PANEL FUNCTIONS                   #
#############################################
*/

//  ADMIN_CATEGORIES start
function insert_categories()
{
    global $connection;

    if (isset($_POST['submit'])) {
        $cat_title = $_POST['cat_title'];
        if ($cat_title == "" || empty($cat_title)) {
            echo "This field should not be empty :)";
        } else {
            $prepare_statement_insert = mysqli_prepare($connection, "INSERT INTO categories(cat_title) VALUE('$cat_title')");

            mysqli_stmt_execute($prepare_statement_insert);

            mysqli_stmt_store_result($prepare_statement_insert);

            //mysqli_stmt_bind_result($prepare_statement_insert, $cat_title);

            if (!$prepare_statement_insert) {
                die("Query failed :(" . mysqli_error($connection));
            }
        }
    }
}

function find_all_cats()
{
    global $connection;

    $query = "SELECT * FROM categories";
    $select_cat = mysqli_query($connection, $query);
    while ($row = mysqli_fetch_assoc($select_cat)) {
        $cat_id = $row['cat_id'];
        $cat_title = $row['cat_title'];

        echo "<tr>";
        echo "<td>{$cat_id}</td>";
        echo "<td>{$cat_title}</td>";
        echo "<td><a href='categories.php?delete={$cat_id}'>Delete</a></td>";
        echo "<td><a href='categories.php?edit={$cat_id}'>Edit</a></td>";
        echo "</tr>";
    }
}

function update_cats()
{
    //  Checks if EDIT has been triggered and parameter has been sent to URL
    //  Then the update field & button will be included and displayed

    global $connection;

    if (isset($_GET['edit'])) {
        $cat_id = $_GET['edit'];
        include("includes/update_categories.php");
    }
}

function delete_cats()
{
    global $connection;

    if (isset($_GET['delete'])) {
        $delete_cat_id = $_GET['delete'];
        $query = "DELETE FROM categories WHERE cat_id={$delete_cat_id}";
        $delete_query = mysqli_query($connection, $query);
        //  "header" sends a raw(?) HTTP header to the client --> refreshing
        header("Location: categories.php");
    }
}

//  ADMIN CATEGORIES end


//  USERS ONLINE start

function users_online()
{
    global $connection;
    //  Session parameters
    $session = session_id();
    $time = time();
    $time_out_seconds = 60;
    $time_out_counter = $time - $time_out_seconds;

    //  Users session query
    $query = "SELECT * FROM users_online WHERE session = '$session'";
    $session_online_query = mysqli_query($connection, $query);
    $count_rows_users_online = mysqli_num_rows($session_online_query);

    //  Insert into users_online table
    if ($count_rows_users_online == NULL) {
        mysqli_query($connection, "INSERT INTO users_online(session, time) VALUES('$session', '$time')");
    } else {
        mysqli_query($connection, "UPDATE users_online SET time = '$time' WHERE session = '$session'");
    }

    //
    $user_online_query = mysqli_query($connection, "SELECT * FROM users_online WHERE time > '$time_out_counter'");
    $user_online_query_count = mysqli_num_rows($user_online_query);

    echo $user_online_query_count;
}

//  USERS ONLINE end
