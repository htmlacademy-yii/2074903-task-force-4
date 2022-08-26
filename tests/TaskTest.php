<?php
namespace tests;

use omarinina\domain\actions\AcceptAction;
use omarinina\domain\actions\CancelAction;
use omarinina\domain\actions\DenyAction;
use omarinina\domain\actions\RespondAction;
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
        $nextStatus = $statusIndicator->changeStatusByAction(RespondAction::getInternalName(), $idUser);
        $this->assertEquals($currentStatus, $nextStatus);
    }

    public function testThreeChangeStatusByAction()
    {
        $statusIndicator = new Task(
            $idClient = 1, $idExecutor = 2, $currentStatus = Task::STATUS_IN_WORK
        );
        $idUser = 2;
        $nextStatus = $statusIndicator->changeStatusByAction(DenyAction::getInternalName(), $idUser);
        $this->assertEquals(Task::STATUS_FAILED, $nextStatus);
    }

    public function testFourChangeStatusByAction()
    {
        $statusIndicator = new Task(
            $idClient = 1, $idExecutor = 2, $currentStatus = Task::STATUS_IN_WORK
        );
        $idUser = 1;
        $nextStatus = $statusIndicator->changeStatusByAction(AcceptAction::getInternalName(), $idUser);
        $this->assertEquals(Task::STATUS_DONE, $nextStatus);
    }

    public function testFiveChangeStatusByAction()
    {
        $statusIndicator = new Task(
            $idClient = 1, $idExecutor = 2, $currentStatus = Task::STATUS_IN_WORK
        );
        $idUser = 2;
        $nextStatus = $statusIndicator->changeStatusByAction(AcceptAction::getInternalName(), $idUser);
        $this->assertEquals($currentStatus, $nextStatus);
    }

    public function testSixChangeStatusByAction()
    {
        $statusIndicator = new Task(
            $idClient = 1, $idExecutor = 2, $currentStatus = Task::STATUS_IN_WORK
        );
        $idUser = 2;
        $nextStatus = $statusIndicator->changeStatusByAction('restart', $idUser);
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

    public function testOneGetAvailableActions()
    {
        $statusIndicator = new Task(
            $idClient = 1, $idExecutor = 2, $currentStatus = Task::STATUS_IN_WORK
        );
        $idUSer = 2;
        $result = $statusIndicator->getAvailableActions($idUSer)->getInternalName();
        $this->assertEquals(DenyAction::getInternalName(), $result);
    }

    public function testTwoGetAvailableActions()
    {
        $statusIndicator = new Task(
            $idClient = 1, $idExecutor = 2, $currentStatus = Task::STATUS_NEW
        );
        $idUSer = 1;
        $result = $statusIndicator->getAvailableActions($idUSer)->getInternalName();
        $this->assertEquals(CancelAction::getInternalName(), $result);
    }

    public function testThreeGetAvailableActions()
    {
        $statusIndicator = new Task(
            $idClient = 1, $idExecutor = 2, $currentStatus = Task::STATUS_DONE
        );
        $idUSer = 1;
        $result = $statusIndicator->getAvailableActions($idUSer);
        $this->assertEquals(null, $result);
    }

}