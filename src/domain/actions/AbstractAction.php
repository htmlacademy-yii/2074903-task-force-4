<?php declare(strict_types=1);

namespace omarinina\domain\actions;

use omarinina\domain\models\task\Tasks;

abstract class AbstractAction
{
    /** @var Tasks */
    protected Tasks $task;

    /**
     * @param Tasks $task
     */
    public function __construct(Tasks $task)
    {
        $this->task = $task;
    }

    /**
     * @return string
     */
    abstract public static function getInternalName(): string;

    /**
     * @return string
     */
    abstract public static function getName(): string;

    /**
     * @return string
     */
    abstract public function getViewAvailableButton(): string;

    abstract public function getAvailableWidget();

    /**
     * @param int $idUser
     * @return bool
     */
    abstract public function isAvailableForUser(int $idUser): bool;
}
