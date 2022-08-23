<?php
namespace tests;

use omarinina\domain\Task;
use PHPUnit\Framework\TestCase;


class TaskTest extends TestCase
{
    public function testOneChangeStatusByAction()
    {
        $statusIndicator = new Task(
            $idClient = 1, $idExecutor = 2, $currentStatus = Task::STATUS_NEW
        );
        $currentUser = 1;
        $mapActions = $statusIndicator->getMapActions();
        $nextStatus = $statusIndicator->changeStatusByAction($this->currentAction = array_keys($mapActions)[0], $currentUser);
        $this->assertEquals(Task::STATUS_CANCELLED, $nextStatus);
    }

    public function testTwoChangeStatusByAction()
    {
        $statusIndicator = new Task(
            $idClient = 1, $idExecutor = 2, $currentStatus = Task::STATUS_NEW
        );
        $currentUser = 2;
        $mapActions = $statusIndicator->getMapActions();
        $nextStatus = $statusIndicator->changeStatusByAction($this->currentAction = array_keys($mapActions)[1], $currentUser);
        $this->assertEquals($currentStatus, $nextStatus);
    }

    public function testGetMapStatuses()
    {
        $statusIndicator = new Task(
            $idClient = 1, $idExecutor = 2, $currentStatus = Task::STATUS_NEW
        );
        $mapStatuses = $statusIndicator->getMapStatuses();
        $result = $mapStatuses[Task::STATUS_DONE];
        $this->assertEquals('Выполнено', $result);
    }

    public function testGetAvailableActions()
    {
        $statusIndicator = new Task(
            $idClient = 1, $idExecutor = 2, $currentStatus = Task::STATUS_IN_WORK
        );
        $mapActions = $statusIndicator->getMapActions();
        $result = $statusIndicator->getAvailableActions()['forExecutor'];
        $this->assertEquals(array_keys($mapActions)[3], $result);
    }

}
