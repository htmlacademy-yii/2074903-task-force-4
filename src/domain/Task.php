<?php declare(strict_types=1);

namespace omarinina\domain;

class Task
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
    private $currentStatus = '';

    public function __construct(int $idClient, int $idExecutor, string $currentStatus)
    {
        $this->idClient = $idClient;
        $this->idExecutor = $idExecutor;
        $this->currentStatus = $currentStatus;
    }

    public static function getMapStatuses() : array
    {
        return [
            self::STATUS_NEW => 'Новое',
            self::STATUS_IN_WORK => 'В работе',
            self::STATUS_CANCELLED => 'Отменено',
            self::STATUS_DONE => 'Выполнено',
            self::STATUS_FAILED => 'Провалено',
        ];
    }

    public static function getMapActions() : array
    {
        return [
            self::ACTION_CANCEL => 'Отменить',
            self::ACTION_RESPOND => 'Откликнуться',
            self::ACTION_ACCEPT => 'Выполнено',
            self::ACTION_DENY => 'Отказаться'
        ];
    }

    public function getCurrentStatus(): string
    {
        return $this->currentStatus;
    }

    public function changeStatusByAction(string $currentAction) : string
    {
        if (array_key_exists($currentAction, $this->getLinkStatusToAction())) {
            if (in_array($currentAction, $this->getAvailableActions())) {
                $this->currentStatus = $this->getLinkStatusToAction()[$currentAction];
            }
        }
        return $this->currentStatus;
    }

    public function getAvailableActions() : array
    {
        $clientActions = $this->getLinkStatusToClientAction()[$this->currentStatus];
        $executorActions = $this->getLinkStatusToExecutorAction()[$this->currentStatus];
        return [
            'forClient' => $clientActions,
            'forExecutor' => $executorActions
        ];
    }

    private static function getLinkStatusToAction() : array
    {
        return [
            self::ACTION_CANCEL => self::STATUS_CANCELLED,
            self::ACTION_ACCEPT => self::STATUS_DONE,
            self::ACTION_DENY => self::STATUS_FAILED
        ];
    }

    private static function getLinkStatusToClientAction() : array
    {
        return [
            self::STATUS_NEW => self::ACTION_CANCEL,
            self::STATUS_IN_WORK => self::ACTION_ACCEPT,
        ];
    }

    private static function getLinkStatusToExecutorAction() : array
    {
        return [
            self::STATUS_NEW => self::ACTION_RESPOND,
            self::STATUS_IN_WORK => self::ACTION_DENY,
        ];
    }
}
