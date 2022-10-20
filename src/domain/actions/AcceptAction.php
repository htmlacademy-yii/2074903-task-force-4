<?php declare(strict_types=1);

namespace omarinina\domain\actions;

use yii\helpers\Url;
use Yii;
use app\widgets\AcceptanceWidget;

class AcceptAction extends AbstractAction
{
    /**
     * @return string
     */
    public static function getInternalName(): string
    {
        return 'accept';
    }

    /**
     * @return string
     */
    public static function getName(): string
    {
        return 'Выполнено';
    }

    /**
     * @return string
     */
    public function getViewAvailableButton(): string
    {
        return '<a href="' .
            Url::toRoute([
                'task-actions/accept-task',
                'taskId' => $this->task->id
            ]) .
            '" class="button button--pink action-btn"
            data-bs-toggle="modal"
            data-bs-target="#acceptance-form"
            data-action="' .
            static::getInternalName() . '">' .
            static::getName() . '</a>';
    }

    public function getAvailableWidget()
    {
        return Yii::$app->user->identity->userRole->role === 'client' ? AcceptanceWidget::widget([]) : '';
    }

    /**
     * @param int $idUser
     * @return bool
     */
    public function isAvailableForUser(int $idUser): bool
    {
        return $this->task->clientId === $idUser;
    }
}
