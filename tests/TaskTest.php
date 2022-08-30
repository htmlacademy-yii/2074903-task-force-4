<?php declare(strict_types=1);
namespace tests;

use omarinina\domain\actions\AcceptAction;
use omarinina\domain\actions\CancelAction;
use omarinina\domain\actions\DenyAction;
use omarinina\domain\actions\RespondAction;
use omarinina\domain\Task;
use PHPUnit\Framework\TestCase;
use omarinina\exception\task\IdUSerException;
use omarinina\exception\task\CurrentActionException;
use omarinina\exception\task\AvailableActionsException;
use Exception;


class TaskTest extends TestCase
{
    public function testOneChangeStatusByAction(): void
    {
        $statusIndicator = new Task(
            $idClient = 1, $idExecutor = 2, $currentStatus = Task::STATUS_NEW
        );
        $idUser = 1;
        try {
            $nextStatus = $statusIndicator->changeStatusByAction(CancelAction::getInternalName(), $idUser);
        } catch (IdUSerException $errorId) {
            $errorId->getMessage();
        } catch (CurrentActionException $errorAction) {
            $errorAction->getMessage();
        } catch (Exception $e) {
            $e->getMessage();
        }
        $this->assertEquals(Task::STATUS_CANCELLED, $nextStatus);
    }

    public function testTwoChangeStatusByAction(): void
    {
        $statusIndicator = new Task(
            $idClient = 1, $idExecutor = 2, $currentStatus = Task::STATUS_NEW
        );
        $idUser = 2;
        try {
            $nextStatus = $statusIndicator->changeStatusByAction(RespondAction::getInternalName(), $idUser);
        } catch (IdUSerException $errorId) {
            $errorId->getMessage();
        } catch (CurrentActionException $errorAction) {
            $errorAction->getMessage();
        } catch (Exception $e) {
            $e->getMessage();
        }
        $this->expectException(CurrentActionException::class);
    }

    public function testThreeChangeStatusByAction(): void
    {
        $statusIndicator = new Task(
            $idClient = 1, $idExecutor = 2, $currentStatus = Task::STATUS_IN_WORK
        );
        $idUser = 2;
        try {
            $nextStatus = $statusIndicator->changeStatusByAction(DenyAction::getInternalName(), $idUser);
        } catch (IdUSerException $errorId) {
            $errorId->getMessage();
        } catch (CurrentActionException $errorAction) {
            $errorAction->getMessage();
        } catch (Exception $e) {
            $e->getMessage();
        }
        $this->assertEquals(Task::STATUS_FAILED, $nextStatus);
    }

    public function testFourChangeStatusByAction(): void
    {
        $statusIndicator = new Task(
            $idClient = 1, $idExecutor = 2, $currentStatus = Task::STATUS_IN_WORK
        );
        $idUser = 1;
        try {
            $nextStatus = $statusIndicator->changeStatusByAction(AcceptAction::getInternalName(), $idUser);
        } catch (IdUSerException $errorId) {
            $errorId->getMessage();
        } catch (CurrentActionException $errorAction) {
            $errorAction->getMessage();
        } catch (Exception $e) {
            $e->getMessage();
        }
        $this->assertEquals(Task::STATUS_DONE, $nextStatus);
    }

    public function testFiveChangeStatusByAction(): void
    {
        $statusIndicator = new Task(
            $idClient = 1, $idExecutor = 2, $currentStatus = Task::STATUS_IN_WORK
        );
        $idUser = 2;
        try {
            $nextStatus = $statusIndicator->changeStatusByAction(AcceptAction::getInternalName(), $idUser);
        } catch (IdUSerException $errorId) {
            $errorId->getMessage();
        } catch (CurrentActionException $errorAction) {
            $errorAction->getMessage();
        } catch (Exception $e) {
            $e->getMessage();
        }
        $this->expectException(IdUSerException::class);
    }

    public function testSixChangeStatusByAction(): void
    {
        $statusIndicator = new Task(
            $idClient = 1, $idExecutor = 2, $currentStatus = Task::STATUS_IN_WORK
        );
        $idUser = 2;
        try {
            $nextStatus = $statusIndicator->changeStatusByAction('restart', $idUser);
        } catch (IdUSerException $errorId) {
            $errorId->getMessage();
        } catch (CurrentActionException $errorAction) {
            $errorAction->getMessage();
        } catch (Exception $e) {
            $e->getMessage();
        }
        $this->expectException(CurrentActionException::class);
    }

    public function testGetMapStatuses(): void
    {
        $statusIndicator = new Task(
            $idClient = 1, $idExecutor = 2, $currentStatus = Task::STATUS_NEW
        );
        $mapStatuses = $statusIndicator->getMapStatuses();
        $result = $mapStatuses[Task::STATUS_DONE];
        $this->assertEquals('Выполнено', $result);
    }

    public function testOneGetAvailableActions(): void
    {
        $statusIndicator = new Task(
            $idClient = 1, $idExecutor = 2, $currentStatus = Task::STATUS_IN_WORK
        );
        $idUSer = 2;
        try {
            $result = $statusIndicator->getAvailableActions($idUSer)->getInternalName();
        } catch (IdUSerException $errorId) {
            $errorId->getMessage();
        } catch (AvailableActionsException $errorActions) {
            $errorActions->getMessage();
        } catch (Exception $e) {
            $e->getMessage();
        }
        $this->assertEquals(DenyAction::getInternalName(), $result);
    }

    public function testTwoGetAvailableActions(): void
    {
        $statusIndicator = new Task(
            $idClient = 1, $idExecutor = 2, $currentStatus = Task::STATUS_NEW
        );
        $idUSer = 1;
        try {
            $result = $statusIndicator->getAvailableActions($idUSer)->getInternalName();
        } catch (IdUSerException $errorId) {
            $errorId->getMessage();
        } catch (AvailableActionsException $errorActions) {
            $errorActions->getMessage();
        } catch (Exception $e) {
            $e->getMessage();
        }
        $this->assertEquals(CancelAction::getInternalName(), $result);
    }

    public function testThreeGetAvailableActions(): void
    {
        $statusIndicator = new Task(
            $idClient = 1, $idExecutor = 2, $currentStatus = Task::STATUS_DONE
        );
        $idUSer = 1;
        try {
            $result = $statusIndicator->getAvailableActions($idUSer);
        } catch (IdUSerException $errorId) {
            $errorId->getMessage();
        } catch (AvailableActionsException $errorActions) {
            $errorActions->getMessage();
        } catch (Exception $e) {
            $e->getMessage();
        }
        $this->expectException(IdUSerException::class);
    }

    public function testFourGetAvailableActions(): void
    {
        $statusIndicator = new Task(
            $idClient = 1, $idExecutor = 2, $currentStatus = Task::STATUS_DONE
        );
        $idUSer = 5;
        try {
            $result = $statusIndicator->getAvailableActions($idUSer);
        } catch (IdUSerException $errorId) {
            $errorId->getMessage();
        } catch (AvailableActionsException $errorActions) {
            $errorActions->getMessage();
        } catch (Exception $e) {
            $e->getMessage();
        }
        $this->expectException(IdUSerException::class);
    }

    public function testFiveGetAvailableActions(): void
    {
        $statusIndicator = new Task(
            $idClient = 1, $idExecutor = 2, $currentStatus = Task::STATUS_DONE
        );
        $idUSer = 1;
        try {
            $result = $statusIndicator->getAvailableActions($idUSer);
        } catch (IdUSerException $errorId) {
            $errorId->getMessage();
        } catch (AvailableActionsException $errorActions) {
            $errorActions->getMessage();
        } catch (Exception $e) {
            $e->getMessage();
        }
        $this->expectException(AvailableActionsException::class);
    }
}
