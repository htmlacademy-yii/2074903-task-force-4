<?php

require_once '../classes/TaskStatusAndActionsIndicator.php';

$idClient = 1;
$idExecutor = 5;
$currentStatus = 'new';
$currentAction = 'respond';

$TaskOneStatusAndActionsIndicator = new TaskStatusAndActionsIndicator(
    $idClient, $idExecutor, $currentStatus, $currentAction
);
$nextStatus = $TaskOneStatusAndActionsIndicator->getNewStatus();

var_dump($TaskOneStatusAndActionsIndicator->getMapStatusesAndActions());
var_dump(assert($nextStatus === TaskStatusAndActionsIndicator::STATUS_IN_WORK));
var_dump($TaskOneStatusAndActionsIndicator->getAvailableActions());
