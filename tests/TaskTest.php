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
            UserId::create(1),
            UserId::create(2),
            Task::STATUS_NEW
        );
        $nextStatus = $statusIndicator->changeStatusByAction(
            CancelAction::getInternalName(),
            UserId::create(1));
        $this->assertEquals(Task::STATUS_CANCELLED, $nextStatus);
    }

    public function testTwoChangeStatusByAction(): void
    {
        $this->expectException(CurrentActionException::class);
        $statusIndicator = new Task(
            UserId::create(1),
            UserId::create(2),
            Task::STATUS_NEW
        );
        $nextStatus = $statusIndicator->changeStatusByAction(
            RespondAction::getInternalName(),
            UserId::create(2));
    }

    public function testThreeChangeStatusByAction(): void
    {
        $statusIndicator = new Task(
            UserId::create(1),
            UserId::create(2),
            Task::STATUS_IN_WORK
        );
        $nextStatus = $statusIndicator->changeStatusByAction(
            DenyAction::getInternalName(),
            UserId::create(2));
        $this->assertEquals(Task::STATUS_FAILED, $nextStatus);
    }

    public function testFourChangeStatusByAction(): void
    {
        $statusIndicator = new Task(
            UserId::create(1),
            UserId::create(2),
            Task::STATUS_IN_WORK
        );
        $nextStatus = $statusIndicator->changeStatusByAction(
            AcceptAction::getInternalName(),
            UserId::create(1));
        $this->assertEquals(Task::STATUS_DONE, $nextStatus);
    }

    public function testFiveChangeStatusByAction(): void
    {
        $this->expectException(IdUSerException::class);
        $statusIndicator = new Task(
            UserId::create(1),
            UserId::create(2),
            Task::STATUS_IN_WORK
        );
        $nextStatus = $statusIndicator->changeStatusByAction(
            AcceptAction::getInternalName(),
            UserId::create(2));
    }

    public function testSixChangeStatusByAction(): void
    {
        $this->expectException(CurrentActionException::class);
        $statusIndicator = new Task(
            UserId::create(1),
            UserId::create(2),
            Task::STATUS_IN_WORK
        );
        $nextStatus = $statusIndicator->changeStatusByAction(
            'restart',
            UserId::create(2));
    }

    public function testGetMapStatuses(): void
    {
        $statusIndicator = new Task(
            UserId::create(1),
            UserId::create(2),
            Task::STATUS_NEW
        );
        $mapStatuses = $statusIndicator->getMapStatuses();
        $result = $mapStatuses[Task::STATUS_DONE];
        $this->assertEquals('Выполнено', $result);
    }

    public function testOneGetAvailableActions(): void
    {
        $statusIndicator = new Task(
            UserId::create(1),
            UserId::create(2),
            Task::STATUS_IN_WORK
        );
        $result = $statusIndicator->
            getAvailableActions(UserId::create(2))->
            getInternalName();
        $this->assertEquals(DenyAction::getInternalName(), $result);
    }

    public function testTwoGetAvailableActions(): void
    {
        $statusIndicator = new Task(
            UserId::create(1),
            UserId::create(2),
            Task::STATUS_NEW
        );
        $result = $statusIndicator->
            getAvailableActions(UserId::create(1))->
            getInternalName();
        $this->assertEquals(CancelAction::getInternalName(), $result);
    }

    public function testThreeGetAvailableActions(): void
    {
        $this->expectException(AvailableActionsException::class);
        $statusIndicator = new Task(
            UserId::create(1),
            UserId::create(2),
            Task::STATUS_DONE
        );
        $result = $statusIndicator->getAvailableActions(UserId::create(1));
    }

    public function testFourGetAvailableActions(): void
    {
        $this->expectException(IdUSerException::class);
        $statusIndicator = new Task(
            UserId::create(1),
            UserId::create(2),
            Task::STATUS_NEW
        );
        $result = $statusIndicator->getAvailableActions(UserId::create(5));
    }

    public function testFiveGetAvailableActions(): void
    {
        $this->expectException(AvailableActionsException::class);
        $statusIndicator = new Task(
            UserId::create(1),
            UserId::create(2),
            Task::STATUS_DONE
        );
        $result = $statusIndicator->getAvailableActions(UserId::create(1));
    }
}
