<?php declare(strict_types=1);

namespace omarinina\domain;

use omarinina\domain\actions\AcceptAction;
use omarinina\domain\actions\CancelAction;
use omarinina\domain\actions\DenyAction;
use omarinina\domain\actions\RespondAction;
use omarinina\domain\actions\AbstractAction;
use omarinina\domain\exception\task\IdUSerException;
use omarinina\domain\exception\task\CurrentActionException;
use omarinina\domain\exception\task\AvailableActionsException;

class Task
{
    const STATUS_NEW = 'new';
    const STATUS_CANCELLED = 'cancelled';
    const STATUS_IN_WORK = 'in work';
    const STATUS_DONE = 'done';
    const STATUS_FAILED = 'failed';

    /** @var int */
    private int $idClient;

    /** @var int */
    private int $idExecutor;

    /** @var string */
    private string $currentStatus;

    /**
     * @param int $idClient
     * @param int $idExecutor
     * @param string $currentStatus
     */
    public function __construct(
        int $idClient,
        int $idExecutor,
        string $currentStatus)
    {
        $this->idClient = $idClient;
        $this->idExecutor = $idExecutor;
        $this->currentStatus = $currentStatus;
    }

    /**
     * @return array
     */
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

    //The same: we have additional buttons for a client, but they didn't change status,
    //should they be added this map?
    /**
     * @return array
     */
    public function getMapActions(): array
    {
        return [
            CancelAction::getInternalName() => CancelAction::getName(),
            RespondAction::getInternalName() => RespondAction::getName(),
            AcceptAction::getInternalName() => AcceptAction::getName(),
            DenyAction::getInternalName() => DenyAction::getName()
        ];
    }

    /**
     * @return string
     */
    public function getCurrentStatus(): string
    {
        return $this->currentStatus;
    }

    //Does saving new status to DB have to be realised in this function?

    /**
     * @param string $currentAction
     * @param int $idUser
     * @return string
     * @throws CurrentActionException Exception when user tries to choose action
     * which is unavailable for this task status
     * @throws IdUserException Exception when user doesn't have rights to add
     * @throws AvailableActionsException
     * changes in this task status
     */
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
        return $this->currentStatus;
    }

    /**
     * @param int $idUser
     * @return AbstractAction|null
     * @throws AvailableActionsException Exception when task has such status
     * which doesn't have any available action for any users
     * @throws IdUserException Exception when user doesn't have rights to add
     * changes in this task status
     */
    public function getAvailableActions(int $idUser): ?AbstractAction
    {
        if (!array_key_exists($this->currentStatus, $this->getLinkStatusToAction())) {
            throw new AvailableActionsException;
        }
        $availableAction = array_values(array_filter(
            $this->getLinkStatusToAction()[$this->currentStatus],
            function (AbstractAction $action) use ($idUser) {
                return $action->isAvailableForUser($idUser);
            }
        ))[0] ?? null;
        if (!$availableAction) {
            throw new IdUSerException;
        }
        return $availableAction;
    }

    /**
     * @return array
     */
    private function getLinkActionToStatus(): array
    {
        return [
            CancelAction::getInternalName() => self::STATUS_CANCELLED,
            AcceptAction::getInternalName() => self::STATUS_DONE,
            DenyAction::getInternalName() => self::STATUS_FAILED
        ];
    }

    //Also the client has two additional buttons when he receives responds by executors.
    //Potential this logic can be realised with this class, isn't it?

    /**
     * @return array
     */
    private function getLinkStatusToAction(): array
    {
        return [
            self::STATUS_NEW => [
                new CancelAction($this->idClient, $this->idExecutor),
                new RespondAction($this->idClient, $this->idExecutor)
            ],
            self::STATUS_IN_WORK => [
                new AcceptAction($this->idClient, $this->idExecutor),
                new DenyAction($this->idClient, $this->idExecutor)
            ]
        ];
    }

    /**
     * @param string $currentAction
     * @param int $idUser
     * @return boolean
     * @throws AvailableActionsException
     * @throws IdUSerException
     */
    private function isValidAction(string $currentAction, int $idUser): bool
    {
        if (array_key_exists($currentAction, $this->getLinkActionToStatus())) {
            return $this->getAvailableActions($idUser)->getInternalName() === $currentAction;
        }
        return false;
    }
}
