<?php declare(strict_types=1);

namespace omarinina\domain;

use Exception;
use omarinina\domain\actions\AcceptAction;
use omarinina\domain\actions\CancelAction;
use omarinina\domain\actions\DenyAction;
use omarinina\domain\actions\RespondAction;
use omarinina\domain\actions\AbstractAction;
use omarinina\domain\exception\task\AvailableActionsException;
use omarinina\domain\exception\task\CurrentActionException;
use omarinina\domain\exception\task\IdUSerException;

class Task
{
    const STATUS_NEW = 'new';
    const STATUS_CANCELLED = 'cancelled';
    const STATUS_IN_WORK = 'in work';
    const STATUS_DONE = 'done';
    const STATUS_FAILED = 'failed';

    private $idClient;
    private $idExecutor;
    private $currentStatus = '';

    public function __construct(int $idClient, int $idExecutor, string $currentStatus)
    {
        $this->idClient = $idClient;
        $this->idExecutor = $idExecutor;
        $this->currentStatus = $currentStatus;
    }

    public static function getMapStatuses(): array
    {
        return [
            self::STATUS_NEW => 'Новое',
            self::STATUS_IN_WORK => 'В работе',
            self::STATUS_CANCELLED => 'Отменено',
            self::STATUS_DONE => 'Выполнено',
            self::STATUS_FAILED => 'Провалено',
        ];
    }

    //The same: we have additional buttoms for a client but they didn't change status,
    //should they be added this map?
    public function getMapActions(): array
    {
        return [
            CancelAction::getInternalName() => CancelAction::getName(),
            RespondAction::getInternalName() => RespondAction::getName(),
            AcceptAction::getInternalName() => AcceptAction::getName(),
            DenyAction::getInternalName() => DenyAction::getName()
        ];
    }

    public function getCurrentStatus(): string
    {
        return $this->currentStatus;
    }

    //Does saving new status to DB have to be realised in this function?
    public function changeStatusByAction(string $currentAction, int $idUser): string
    {
        if ($this->isValidAction($currentAction, $idUser)) {
            return $this->currentStatus = $this->getLinkActionToStatus()[$currentAction];
        }
        if (!array_key_exists($currentAction, $this->getLinkActionToStatus())) {
            throw new CurrentActionException;
        }
        if ($this->getAvailableActions($idUser)->getInternalName() !== $currentAction) {
            throw new IdUSerException;
        }
    }

    public function getAvailableActions(int $idUser): ?AbstractAction
    {
        $availableActions = $this->getLinkStatusToAction()[$this->currentStatus];
        if (!$availableActions) {
            throw new AvailableActionsException;
        }
        $availableAction = array_values(array_filter(
            $availableActions,
            function (AbstractAction $action) use ($idUser) {
                return $action->isAvailableForUser($idUser, $this->idClient, $this->idExecutor);
            }
        ))[0];
        if (!$availableAction) {
            throw new IdUSerException;
        }
        return $availableAction;
    }

    private function getLinkActionToStatus(): array
    {
        return [
            CancelAction::getInternalName() => self::STATUS_CANCELLED,
            AcceptAction::getInternalName() => self::STATUS_DONE,
            DenyAction::getInternalName() => self::STATUS_FAILED
        ];
    }

    //Also the client has two additional buttoms when he recives reponds by executors.
    //Potential this logic can be realised with this class, isn't it?

    private function getLinkStatusToAction(): array
    {
        return [
            self::STATUS_NEW => [
                new CancelAction,
                new RespondAction
            ],
            self::STATUS_IN_WORK => [
                new AcceptAction,
                new DenyAction
            ]
        ];
    }

    private function isValidAction(string $currentAction, int $idUser): bool
    {
        if (array_key_exists($currentAction, $this->getLinkActionToStatus())) {
            return $this->getAvailableActions($idUser)->getInternalName() === $currentAction;
        }
        return false;
    }
}
