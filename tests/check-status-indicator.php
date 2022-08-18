<?php

$root = __DIR__ . '/../';
require_once $root . "/classes/Task.php";

$idClient = 1;
$idExecutor = 5;
$currentStatus = Task::STATUS_NEW;
$currentAction = Task::ACTION_RESPOND;

$TaskOneStatusAndActionsIndicator = new Task(
    $idClient, $idExecutor, $currentStatus, $currentAction
);
$nextStatus = $TaskOneStatusAndActionsIndicator->changeStatusByAction($currentAction);

var_dump($TaskOneStatusAndActionsIndicator->getMapStatuses());
var_dump($TaskOneStatusAndActionsIndicator->getMapActions());
var_dump(assert($nextStatus === Task::STATUS_IN_WORK));
var_dump($TaskOneStatusAndActionsIndicator->getAvailableActions());
