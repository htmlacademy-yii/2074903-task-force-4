<?php declare(strict_types=1);

use omarinina\infrastructure\converting\CsvToSqlConverter;
use omarinina\infrastructure\exception\FileExistException;
use omarinina\infrastructure\exception\FileOpenException;
use omarinina\infrastructure\exception\HeaderColumsException;
use \Throwable;

$root = __DIR__;
require_once $root.'/vendor/autoload.php';
require_once 'init.php';

$converterCsvToSqlCities = new CsvToSqlConverter(
    $root.'/data/cities.csv',
    $root.'/sql/cities.sql',
    'cities',
    ['name', 'lat', 'long']);

try {
    $converterCsvToSqlCities->runParseCsvToSql();
    print('Записали, проверяй');
} catch (FileExistException | FileOpenException | HeaderColumsException $e) {
    print($e->getMessage());
    die();
} catch (Throwable $e) {
    print('Системная ошибка, попробуйте позднее');
    error_log('Error: '.$e->getMessage().'<\br>', 3, __DIR__.'/errors.log');
    die();
}

$converterCsvToSqlCategories = new CsvToSqlConverter(
    $root.'/data/categories.csv',
    $root.'/sql/categories.sql',
    'categories',
    ['name', 'icon']);

try {
    $converterCsvToSqlCities->runParseCsvToSql();
    print('Записали, проверяй');
} catch (FileExistException | FileOpenException | HeaderColumsException $e) {
    print($e->getMessage());
    die();
} catch (Throwable $e) {
    print('Системная ошибка, попробуйте позднее');
    error_log('Error: '.$e->getMessage().'<\br>', 3, __DIR__.'/errors.log');
    die();
}

