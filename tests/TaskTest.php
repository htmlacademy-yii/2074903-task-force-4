<?php
namespace tests;

use omarinina\domain\Task;
use PHPUnit\Framework\TestCase;


class TaskTest extends TestCase
{
    public function testOneChangeStatusByAction()
    {
        $statusIndicator = new Task(
            $idClient = 1, $idExecutor = 1, $currentStatus = Task::STATUS_NEW
        );
        $nextStatus = $statusIndicator->changeStatusByAction($this->currentAction = Task::ACTION_CANCEL);
        $this->assertEquals(Task::STATUS_CANCELLED, $nextStatus);
    }

    public function testTwoChangeStatusByAction()
    {
        $statusIndicator = new Task(
            $idClient = 1, $idExecutor = 1, $currentStatus = Task::STATUS_NEW
        );
        $nextStatus = $statusIndicator->changeStatusByAction($this->currentAction = Task::ACTION_RESPOND);
        $this->assertEquals($statusIndicator->getCurrentStatus(), $nextStatus);
    }

    public function testGetMapStatuses()
    {
        $statusIndicator = new Task(
            $idClient = 1, $idExecutor = 1, $currentStatus = Task::STATUS_NEW
        );
        $mapStatuses = $statusIndicator->getMapStatuses();
        $result = $mapStatuses[Task::STATUS_DONE];
        $this->assertEquals('Выполнено', $result);
    }

    public function testGetAvailableActions()
    {
        $statusIndicator = new Task(
            $idClient = 1, $idExecutor = 1, $currentStatus = Task::STATUS_IN_WORK
        );
        $result = $statusIndicator->getAvailableActions()['forExecutor'];
        $this->assertEquals(Task::ACTION_DENY, $result);
    }

}
