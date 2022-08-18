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
    public static function getMapActions(): array
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

    //Does saving new status to DB have to be realised in this function?
    public function changeStatusByAction(string $currentAction): string
    {
        if (array_key_exists($currentAction, $this->getLinkStatusToAction())) {
            if (in_array($currentAction, $this->getAvailableActions())) {
                //In the future development there needs validator of person (client/executor)
                //because client hasn't to send an executor's respond and also for executor
                $this->currentStatus = $this->getLinkStatusToAction()[$currentAction];
            }
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

    private static function getLinkStatusToAction(): array
    {
        return [
            self::ACTION_CANCEL => self::STATUS_CANCELLED,
            self::ACTION_ACCEPT => self::STATUS_DONE,
            self::ACTION_DENY => self::STATUS_FAILED
        ];
    }

    //Also the client has two additional buttoms when he recives reponds by executors.
    //Potential this logic can be realised with this class, isn't it?

    private static function getLinkStatusToClientAction(): array
    {
        return [
            self::STATUS_NEW => self::ACTION_CANCEL,
            self::STATUS_IN_WORK => self::ACTION_ACCEPT,
        ];
    }

    private static function getLinkStatusToExecutorAction(): array
    {
        return [
            self::STATUS_NEW => self::ACTION_RESPOND,
            self::STATUS_IN_WORK => self::ACTION_DENY,
        ];
    }
}
