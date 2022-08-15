<?php

//require_once '../classes/TaskStatusAndActionsIndicator.php';
//require_once 'vendor/autoload.php';
use phpunit\Framework\TestCase;
use Omarinina\classes\TaskStatusAndActionsIndicator;

class StatusIndicatorTests extends TestCase
{
    private $idClient = 1;
    private $idExecutor = 5;
    private $currentStatus = 'new';
    private $currentAction = 'respond';
    private $statusIndicator;

    public function testGetNewStatus()
    {
        $this->statusIndicator = new TaskStatusAndActionsIndicator(
            $this->idClient, $this->idExecutor, $this->currentStatus, $this->currentAction
        );
        $nextStatus = $this->statusIndicator->getNewStatus();
        $this->assertEquals(TaskStatusAndActionsIndicator::STATUS_IN_WORK, $nextStatus);
    }

    public function testGetMapStatusesAndActions()
    {
        $this->statusIndicator = new TaskStatusAndActionsIndicator(
            $this->idClient, $this->idExecutor, $this->currentStatus, $this->currentAction
        );
        $mapStatusesAndActions = $this->statusIndicator->getMapStatusesAndActions();
        $result = $mapStatusesAndActions['cancel'];
        $this->assertEquals(TaskStatusAndActionsIndicator::ACTION_CANCEL, array_search($result, $mapStatusesAndActions, $string = false));
    }

    public function testGetAvailableActions()
    {
        $this->statusIndicator = new TaskStatusAndActionsIndicator(
            $this->idClient, $this->idExecutor, $this->currentStatus, $this->currentAction
        );
        $availableActions = $this->statusIndicator->getAvailableActions();
        $clientAction = $availableActions['for client'];
        $this->assertEquals(TaskStatusAndActionsIndicator::ACTION_ACCEPT, $clientAction);
    }

}

/*$idClient = 1;
$idExecutor = 5;
$currentStatus = 'new';
$currentAction = 'respond';

$TaskOneStatusAndActionsIndicator = new TaskStatusAndActionsIndicator(
    $idClient, $idExecutor, $currentStatus, $currentAction
);
$nextStatus = $TaskOneStatusAndActionsIndicator->getNewStatus();

var_dump($TaskOneStatusAndActionsIndicator->getMapStatusesAndActions());
var_dump(assert($nextStatus === TaskStatusAndActionsIndicator::STATUS_IN_WORK));
var_dump($TaskOneStatusAndActionsIndicator->getAvailableActions());*/
