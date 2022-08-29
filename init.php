<?php

require_once 'config/db.php';

try {
    $connect = new PDO(
        'mysql:host='.$db['host'].';dbname='.$db['database'],
        $db['user'],
        $db['password'],
        array(PDO::ATTR_PERSISTENT => true));
} catch (PDOException $dbError) {
    print('Error: '.$dbError->getMessage().'<br/>');
    die();
}
