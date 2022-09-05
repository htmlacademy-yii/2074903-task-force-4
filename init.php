<?php

require_once 'config/db.php';

try {
    $connect = new PDO(
        'mysql:host='.$db['host'].';dbname='.$db['database'],
        $db['user'],
        $db['password'],
        array(PDO::ATTR_PERSISTENT => true));
} catch (PDOException $e) {
    print('Ошибка соединения с базой данных, попробуйте позднее');
    error_log('Error: '.$e->getMessage().'<\br>', 3, __DIR__.'/errors.log');
    die();
} catch (Throwable $e) {
    print('Системная ошибка, попробуйте позднее');
    error_log('Error: '.$e->getMessage().'<\br>', 3, __DIR__.'/errors.log');
    die();
}
