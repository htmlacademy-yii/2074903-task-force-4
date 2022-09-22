<?php
namespace tests;

use omarinina\domain\actions\AcceptAction;
use omarinina\domain\actions\CancelAction;
use omarinina\domain\actions\DenyAction;
use omarinina\domain\actions\RespondAction;
use omarinina\domain\Task;
use PHPUnit\Framework\TestCase;
use omarinina\domain\exception\task\IdUSerException;
use omarinina\domain\exception\task\CurrentActionException;
use omarinina\domain\exception\task\AvailableActionsException;
use omarinina\domain\valueObjects\UniqueIdentification;

class TaskTest extends TestCase
{
    public function testOneChangeStatusByAction(): void
    {
        $user1 = new UniqueIdentification();
        $user2 = new UniqueIdentification();
        $statusIndicator = new Task(
            $user1,
            $user2,
            Task::STATUS_NEW
        );
        $nextStatus = $statusIndicator->changeStatusByAction(
            CancelAction::getInternalName(),
            $user1);
        $this->assertEquals(Task::STATUS_CANCELLED, $nextStatus);
    }

    public function testTwoChangeStatusByAction(): void
    {
        $this->expectException(CurrentActionException::class);
        $user1 = new UniqueIdentification();
        $user2 = new UniqueIdentification();
        $statusIndicator = new Task(
            $user1,
            $user2,
            Task::STATUS_NEW
        );
        $nextStatus = $statusIndicator->changeStatusByAction(
            RespondAction::getInternalName(),
            $user2);
    }

    public function testThreeChangeStatusByAction(): void
    {
        $user1 = new UniqueIdentification();
        $user2 = new UniqueIdentification();
        $statusIndicator = new Task(
            $user1,
            $user2,
            Task::STATUS_IN_WORK
        );
        $nextStatus = $statusIndicator->changeStatusByAction(
            DenyAction::getInternalName(),
            $user2);
        $this->assertEquals(Task::STATUS_FAILED, $nextStatus);
    }

    public function testFourChangeStatusByAction(): void
    {
        $user1 = new UniqueIdentification();
        $user2 = new UniqueIdentification();
        $statusIndicator = new Task(
            $user1,
            $user2,
            Task::STATUS_IN_WORK
        );
        $nextStatus = $statusIndicator->changeStatusByAction(
            AcceptAction::getInternalName(),
            $user1);
        $this->assertEquals(Task::STATUS_DONE, $nextStatus);
    }

    public function testFiveChangeStatusByAction(): void
    {
        $user1 = new UniqueIdentification();
        $user2 = new UniqueIdentification();
        $this->expectException(IdUSerException::class);
        $statusIndicator = new Task(
            $user1,
            $user2,
            Task::STATUS_IN_WORK
        );
        $nextStatus = $statusIndicator->changeStatusByAction(
            AcceptAction::getInternalName(),
            $user2);
    }

    public function testSixChangeStatusByAction(): void
    {
        $user1 = new UniqueIdentification();
        $user2 = new UniqueIdentification();
        $this->expectException(CurrentActionException::class);
        $statusIndicator = new Task(
            $user1,
            $user2,
            Task::STATUS_IN_WORK
        );
        $nextStatus = $statusIndicator->changeStatusByAction(
            'restart',
            $user2);
    }

    public function testGetMapStatuses(): void
    {
        $user1 = new UniqueIdentification();
        $user2 = new UniqueIdentification();
        $statusIndicator = new Task(
            $user1,
            $user2,
            Task::STATUS_NEW
        );
        $mapStatuses = $statusIndicator->getMapStatuses();
        $result = $mapStatuses[Task::STATUS_DONE];
        $this->assertEquals('Выполнено', $result);
    }

    public function testOneGetAvailableActions(): void
    {
        $user1 = new UniqueIdentification();
        $user2 = new UniqueIdentification();
        $statusIndicator = new Task(
            $user1,
            $user2,
            Task::STATUS_IN_WORK
        );
        $result = $statusIndicator->
            getAvailableActions($user2)->
            getInternalName();
        $this->assertEquals(DenyAction::getInternalName(), $result);
    }

    public function testTwoGetAvailableActions(): void
    {
        $user1 = new UniqueIdentification();
        $user2 = new UniqueIdentification();
        $statusIndicator = new Task(
            $user1,
            $user2,
            Task::STATUS_NEW
        );
        $result = $statusIndicator->
            getAvailableActions($user1)->
            getInternalName();
        $this->assertEquals(CancelAction::getInternalName(), $result);
    }

    public function testThreeGetAvailableActions(): void
    {
        $user1 = new UniqueIdentification();
        $user2 = new UniqueIdentification();
        $this->expectException(AvailableActionsException::class);
        $statusIndicator = new Task(
            $user1,
            $user2,
            Task::STATUS_DONE
        );
        $result = $statusIndicator->getAvailableActions($user1);
    }

    public function testFourGetAvailableActions(): void
    {
        $user1 = new UniqueIdentification();
        $user2 = new UniqueIdentification();
        $user3 = new UniqueIdentification();
        $this->expectException(IdUSerException::class);
        $statusIndicator = new Task(
            $user1,
            $user2,
            Task::STATUS_NEW
        );
        $result = $statusIndicator->getAvailableActions($user3);
    }

    public function testFiveGetAvailableActions(): void
    {
        $user1 = new UniqueIdentification();
        $user2 = new UniqueIdentification();
        $this->expectException(AvailableActionsException::class);
        $statusIndicator = new Task(
            $user1,
            $user2,
            Task::STATUS_DONE
        );
        $result = $statusIndicator->getAvailableActions($user1);
    }
}
