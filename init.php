<?php

require_once 'config/db.php';

$connect = mysqli_connect($db['host'], $db['user'], $db['password'], $db['database']);
mysqli_set_charset($connect, 'utf8');

if (!$connect) {
    $dbError = mysqli_connect_error();
};
