<?php

$root = __DIR__;
require_once $root . '/vendor/autoload.php';
require_once 'init.php';

use omarinina\domain\Task;
use omarinina\exception\IdUSerException;
use omarinina\exception\CurrentActionException;

//Example new object of class
$newTask = new Task(1, 2, Task::STATUS_NEW);

try {
    $newTask->changeStatusByAction('cancel', 2);
} catch (IdUSerException $errorId) {
    $errorId->getMessage();
} catch (CurrentActionException $errorAction) {
    $errorAction->getMessage();
} catch (Exception $e) {
    $e->getMessage();
}

