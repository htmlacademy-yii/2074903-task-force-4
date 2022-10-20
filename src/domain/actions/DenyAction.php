<?php declare(strict_types=1);

namespace omarinina\domain\actions;

use yii\helpers\Url;
use Yii;
use app\widgets\DenialWidget;

class DenyAction extends AbstractAction
{
    /**
     * @return string
     */
    public static function getInternalName(): string
    {
        return 'deny';
    }

    /**
     * @return string
     */
    public static function getName(): string
    {
        return 'Отказаться';
    }

    /**
     * @return string
     */
    public function getViewAvailableButton(): string
    {
        return '<a href="' .
            Url::toRoute([
                'task-actions/deny-task',
                'taskId' => $this->task->id
            ]) .
            '" class="button button--orange action-btn"
            data-bs-toggle="modal"
            data-bs-target="#denial-form"
            data-action="' .
            static::getInternalName() . '">' .
            static::getName() . '</a>';
    }

    public function getAvailableWidget()
    {
        return Yii::$app->user->identity->userRole->role === 'executor' ? DenialWidget::widget([]) : '';
    }

    /**
     * @param int $idUser
     * @return bool
     */
    public function isAvailableForUser(int $idUser): bool
    {
        return $this->task->executorId === $idUser;
    }
}
