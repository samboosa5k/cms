<?php

$db_address = 'localhost';
$db_user = 'root';
$db_pass = '';
$db_name = 'cms';

$db['db_address'] = "localhost";
$db['db_user'] = "root";
$db['db_pass'] = "";
$db['db_name'] = "cms";

//  Below foreach converts array keys to UPPERCASE constants...
//  ...constants are immediately global and can be used everywhere --> Good practice!
foreach ($db as $key => $value) {
    define(strtoupper($key), $value);
}

$connection = mysqli_connect(DB_ADDRESS, DB_USER, DB_PASS, DB_NAME);

/* if ($connection) {
    echo "We are connected";
} */
