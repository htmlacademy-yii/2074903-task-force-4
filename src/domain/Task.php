<?php declare(strict_types=1);

namespace omarinina\domain;

use omarinina\domain\actions\AcceptAction;
use omarinina\domain\actions\CancelAction;
use omarinina\domain\actions\DenyAction;
use omarinina\domain\actions\RespondAction;

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

    private $actionCancel;
    private $actionRespond;
    private $actionAccept;
    private $actionDeny;

    public function __construct(int $idClient, int $idExecutor, string $currentStatus)
    {
        $this->idClient = $idClient;
        $this->idExecutor = $idExecutor;
        $this->currentStatus = $currentStatus;
        $this->actionCancel = new CancelAction($this->idClient, $this->idExecutor);
        $this->actionRespond = new RespondAction($this->idClient, $this->idExecutor);
        $this->actionAccept = new AcceptAction($this->idClient, $this->idExecutor);
        $this->actionDeny = new DenyAction($this->idClient, $this->idExecutor);
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
            $this->actionCancel->getAction() => $this->actionCancel->getNameAction(),
            $this->actionRespond->getAction() => $this->actionRespond->getNameAction(),
            $this->actionAccept->getAction() => $this->actionAccept->getNameAction(),
            $this->actionDeny->getAction() => $this->actionDeny->getNameAction(),
        ];
    }

    public function getCurrentStatus(): string
    {
        return $this->currentStatus;
    }

    //Does saving new status to DB have to be realised in this function?
    public function changeStatusByAction(string $currentAction, int $currentUser): string
    {
        if ($this->isValidAction($currentAction, $currentUser)) {
            $this->currentStatus = $this->getLinkStatusToAction()[$currentAction];
        }
        return $this->currentStatus;
    }

    public function getAvailableActions(): array
    {
        $clientActions = $this->getLinkStatusToClientAction()[$this->currentStatus];
        $executorActions = $this->getLinkStatusToExecutorAction()[$this->currentStatus];
        return [
            'forClient' => $clientActions,
            'forExecutor' => $executorActions
        ];
    }

    private function getLinkStatusToAction(): array
    {
        return [
            $this->actionCancel->getAction() => self::STATUS_CANCELLED,
            $this->actionAccept->getAction() => self::STATUS_DONE,
            $this->actionDeny->getAction() => self::STATUS_FAILED
        ];
    }

    //Also the client has two additional buttoms when he recives reponds by executors.
    //Potential this logic can be realised with this class, isn't it?

    private function getLinkStatusToClientAction(): array
    {
        return [
            self::STATUS_NEW => $this->actionCancel->getAction(),
            self::STATUS_IN_WORK => $this->actionAccept->getAction(),
        ];
    }

    private function getLinkStatusToExecutorAction(): array
    {
        return [
            self::STATUS_NEW => $this->actionRespond->getAction(),
            self::STATUS_IN_WORK => $this->actionDeny->getAction(),
        ];
    }

    private function isValidAction(string $currentAction, int $currentUser)
    {
        if (array_key_exists($currentAction, $this->getLinkStatusToAction())) {
            if (in_array($currentAction, $this->getAvailableActions()) && $this->isAvailableUserAction($currentAction, $currentUser)) {
                return true;
            }
        }
    }

    private function isAvailableUserAction(string $currentAction, int $currentUser): bool
    {
        //I can't create good name here (
        $chekingAction = [
            $this->actionAccept->isValidUser($currentUser, $currentAction),
            $this->actionCancel->isValidUser($currentUser, $currentAction),
            $this->actionDeny->isValidUser($currentUser, $currentAction),
            $this->actionRespond->isValidUser($currentUser, $currentAction)
        ];
        return in_array(true, $chekingAction);
    }
}
