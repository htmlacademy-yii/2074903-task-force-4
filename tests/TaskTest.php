<?php

use PHPUnit\Framework\TestCase;
use omarinina\domain\Task;

class StatusIndicatorTests extends TestCase
{
    private $currentAction = Task::ACTION_CANCEL;

    public function testOneChangeStatusByAction()
    {
        $statusIndicator = self::getTask(
            $this->idClient, $this->idExecutor, $this->currentStatus
        );
        $nextStatus = $statusIndicator->changeStatusByAction($this->currentAction);
        $this->assertEquals(Task::STATUS_CANCELLED, $nextStatus);
    }

    public function testTwoChangeStatusByAction()
    {
        $statusIndicator = self::getTask(
            $this->idClient, $this->idExecutor, $this->currentStatus
        );
        $nextStatus = $statusIndicator->changeStatusByAction($this->currentAction = Task::ACTION_RESPOND);
        $this->assertEquals($statusIndicator->getCurrentStatus(), $nextStatus);
    }

    public function testGetMapStatuses()
    {
        $statusIndicator = self::getTask(
            $this->idClient, $this->idExecutor, $this->currentStatus
        );
        $mapStatuses = $statusIndicator->getMapStatuses();
        $result = $mapStatuses[Task::STATUS_DONE];
        $this->assertEquals(Task::ACTION_ACCEPT, array_search($result, $mapStatuses));
    }

    public function testGetAvailableActions()
    {
        $statusIndicator = self::getTask(
            $this->idClient, $this->idExecutor, $this->currentStatus = Task::STATUS_IN_WORK
        );
        $availableActions = $statusIndicator->getAvailableActions();
        $executorAction = $availableActions['forExecutor'];
        $this->assertEquals(Task::ACTION_DENY, $executorAction);
    }

    private static function getTask(
        int $idClient = '1',
        int $idExecutor = '1',
        string $currentStatus = Task::STATUS_NEW
    ): Task
    {
        return new Task(
            $idClient, $idExecutor, $currentStatus
        );
    }

}
