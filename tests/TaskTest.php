<?php
namespace tests;

use omarinina\domain\actions\CancelAction;
use omarinina\domain\actions\DenyAction;
use omarinina\domain\Task;
use PHPUnit\Framework\TestCase;


class TaskTest extends TestCase
{
    public function testOneChangeStatusByAction()
    {
        $statusIndicator = new Task(
            $idClient = 1, $idExecutor = 2, $currentStatus = Task::STATUS_NEW
        );
        $idUser = 1;
        $nextStatus = $statusIndicator->changeStatusByAction(CancelAction::getInternalName(), $idUser);
        $this->assertEquals(Task::STATUS_CANCELLED, $nextStatus);
    }

    public function testTwoChangeStatusByAction()
    {
        $statusIndicator = new Task(
            $idClient = 1, $idExecutor = 2, $currentStatus = Task::STATUS_NEW
        );
        $idUser = 2;
        $mapActions = $statusIndicator->getMapActions();
        $nextStatus = $statusIndicator->changeStatusByAction($this->currentAction = array_keys($mapActions)[1], $idUser);
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
        $idUSer = 2;
        $result = $statusIndicator->getAvailableActions($idUSer)->getInternalName();
        $this->assertEquals(DenyAction::getInternalName(), $result);
    }

}
