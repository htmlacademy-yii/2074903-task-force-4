<?php

namespace Omarinina\classes;

class TaskStatusAndActionsIndicator
{
    const STATUS_NEW = 'new';
    const STATUS_CANCELLED = 'cancelled';
    const STATUS_IN_WORK = 'in work';
    const STATUS_DONE = 'done';
    const STATUS_FAILED = 'failed';

    const ACTION_CANCEL = 'cancel';
    const ACTION_RESPOND = 'respond';
    const ACTION_ACCEPT = 'accept';
    const ACTION_DENY = 'deny';

    private $idClient;
    private $idExecutor;

    public $currentStatus = '';
    public $currentAction = '';

    public function __construct(int $idClient, int $idExecutor, string $currentStatus, string $currentAction)
    {
        $this->idClient = $idClient;
        $this->idExecutor = $idExecutor;
        $this->currentStatus = $currentStatus;
        $this->currentAction = $currentAction;
    }

    public function getMapStatusesAndActions() : array
    {
        return [
            self::STATUS_NEW => 'Новое',
            self::STATUS_IN_WORK => 'В работе',
            self::STATUS_CANCELLED => 'Отменено',
            self::STATUS_DONE => 'Выполнено',
            self::STATUS_FAILED => 'Провалено',

            self::ACTION_CANCEL => 'Отменить',
            self::ACTION_RESPOND => 'Откликнуться',
            self::ACTION_ACCEPT => 'Выполнено',
            self::ACTION_DENY => 'Отказаться'
        ];
    }

    public function getNewStatus() : string
    {
        $statusesByActions = $this->linkStatusToAction();
        if ($this->currentAction) {
        $this->currentStatus = $statusesByActions[$this->currentAction];
        };
        return $this->currentStatus;
    }

    public function getAvailableActions() : array
    {
        $clientActions = $this->linkStatusToClientAction();
        $executorActions = $this->linkStatusToExecutorAction();
        return [
            'for client' => $clientActions[$this->currentStatus],
            'for executor' => $executorActions[$this->currentStatus]
        ];
    }

    private function linkStatusToAction() : array
    {
        return [
            self::ACTION_CANCEL => self::STATUS_CANCELLED,
            self::ACTION_RESPOND => self::STATUS_IN_WORK,
            self::ACTION_ACCEPT => self::STATUS_DONE,
            self::ACTION_DENY => self::STATUS_FAILED
        ];
    }

    private function linkStatusToClientAction() : array
    {
        return [
            self::STATUS_NEW => self::ACTION_CANCEL,
            self::STATUS_IN_WORK => self::ACTION_ACCEPT,
            self::STATUS_CANCELLED => null,
            self::STATUS_DONE => null,
            self::STATUS_FAILED => null
        ];
    }

    private function linkStatusToExecutorAction() : array
    {
        return [
            self::STATUS_NEW => self::ACTION_RESPOND,
            self::STATUS_IN_WORK => self::ACTION_DENY,
            self::STATUS_CANCELLED => null,
            self::STATUS_DONE => null,
            self::STATUS_FAILED => null
        ];
    }
}
