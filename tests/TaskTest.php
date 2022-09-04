<?php
namespace tests;

use omarinina\domain\actions\AcceptAction;
use omarinina\domain\actions\CancelAction;
use omarinina\domain\actions\DenyAction;
use omarinina\domain\actions\RespondAction;
use omarinina\domain\Task;
use PHPUnit\Framework\TestCase;
use omarinina\exception\IdUSerException;
use omarinina\exception\CurrentActionException;
use omarinina\exception\AvailableActionsException;
use omarinina\domain\valueObjects\UserId;

class TaskTest extends TestCase
{
    public function testOneChangeStatusByAction(): void
    {
        $statusIndicator = new Task(
            $idClient = new UserId('1'),
            $idExecutor = new UserId('2'),
            $currentStatus = Task::STATUS_NEW
        );
        $idUser = new UserId('1');
        $nextStatus = $statusIndicator->changeStatusByAction(CancelAction::getInternalName(), $idUser);
        $this->assertEquals(Task::STATUS_CANCELLED, $nextStatus);
    }

    public function testTwoChangeStatusByAction(): void
    {
        $this->expectException(CurrentActionException::class);
        $statusIndicator = new Task(
            $idClient = new UserId('1'),
            $idExecutor = new UserId('2'),
            $currentStatus = Task::STATUS_NEW
        );
        $idUser = new UserId('2');
        $nextStatus = $statusIndicator->changeStatusByAction(RespondAction::getInternalName(), $idUser);
    }

    public function testThreeChangeStatusByAction(): void
    {
        $statusIndicator = new Task(
            $idClient = new UserId('1'),
            $idExecutor = new UserId('2'),
            $currentStatus = Task::STATUS_IN_WORK
        );
        $idUser = new UserId('2');
        $nextStatus = $statusIndicator->changeStatusByAction(DenyAction::getInternalName(), $idUser);
        $this->assertEquals(Task::STATUS_FAILED, $nextStatus);
    }

    public function testFourChangeStatusByAction(): void
    {
        $statusIndicator = new Task(
            $idClient = new UserId('1'),
            $idExecutor = new UserId('2'),
            $currentStatus = Task::STATUS_IN_WORK
        );
        $idUser = new UserId('1');
        $nextStatus = $statusIndicator->changeStatusByAction(AcceptAction::getInternalName(), $idUser);
        $this->assertEquals(Task::STATUS_DONE, $nextStatus);
    }

    public function testFiveChangeStatusByAction(): void
    {
        $this->expectException(IdUSerException::class);
        $statusIndicator = new Task(
            $idClient = new UserId('1'),
            $idExecutor = new UserId('2'),
            $currentStatus = Task::STATUS_IN_WORK
        );
        $idUser = new UserId('2');
        $nextStatus = $statusIndicator->changeStatusByAction(AcceptAction::getInternalName(), $idUser);
    }

    public function testSixChangeStatusByAction(): void
    {
        $this->expectException(CurrentActionException::class);
        $statusIndicator = new Task(
            $idClient = new UserId('1'),
            $idExecutor = new UserId('2'),
            $currentStatus = Task::STATUS_IN_WORK
        );
        $idUser = new UserId('2');
        $nextStatus = $statusIndicator->changeStatusByAction('restart', $idUser);
    }

    public function testGetMapStatuses(): void
    {
        $statusIndicator = new Task(
            $idClient = new UserId('1'),
            $idExecutor = new UserId('2'),
            $currentStatus = Task::STATUS_NEW
        );
        $mapStatuses = $statusIndicator->getMapStatuses();
        $result = $mapStatuses[Task::STATUS_DONE];
        $this->assertEquals('Выполнено', $result);
    }

    public function testOneGetAvailableActions(): void
    {
        $statusIndicator = new Task(
            $idClient = new UserId('1'),
            $idExecutor = new UserId('2'),
            $currentStatus = Task::STATUS_IN_WORK
        );
        $idUSer = new UserId('2');
        $result = $statusIndicator->getAvailableActions($idUSer)->getInternalName();
        $this->assertEquals(DenyAction::getInternalName(), $result);
    }

    public function testTwoGetAvailableActions(): void
    {
        $statusIndicator = new Task(
            $idClient = new UserId('1'),
            $idExecutor = new UserId('2'),
            $currentStatus = Task::STATUS_NEW
        );
        $idUSer = new UserId('1');
        $result = $statusIndicator->getAvailableActions($idUSer)->getInternalName();
        $this->assertEquals(CancelAction::getInternalName(), $result);
    }

    public function testThreeGetAvailableActions(): void
    {
        $this->expectException(IdUSerException::class);
        $statusIndicator = new Task(
            $idClient = new UserId('1'),
            $idExecutor = new UserId('2'),
            $currentStatus = Task::STATUS_DONE
        );
        $idUSer = new UserId('1');
        $result = $statusIndicator->getAvailableActions($idUSer);
    }

    public function testFourGetAvailableActions(): void
    {
        $this->expectException(IdUSerException::class);
        $statusIndicator = new Task(
            $idClient = new UserId('1'),
            $idExecutor = new UserId('2'),
            $currentStatus = Task::STATUS_DONE
        );
        $idUSer = new UserId('5');
        $result = $statusIndicator->getAvailableActions($idUSer);
    }

    public function testFiveGetAvailableActions(): void
    {
        $this->expectException(AvailableActionsException::class);
        $statusIndicator = new Task(
            $idClient = new UserId('1'),
            $idExecutor = new UserId('2'),
            $currentStatus = Task::STATUS_DONE
        );
        $idUSer = new UserId('1');
        $result = $statusIndicator->getAvailableActions($idUSer);
    }
}
