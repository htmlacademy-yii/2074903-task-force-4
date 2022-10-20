<?php declare(strict_types=1);

namespace omarinina\domain\actions;

use omarinina\domain\models\task\Tasks;
use yii\helpers\Url;
use Yii;
use app\widgets\CancellationWidget;

class CancelAction extends AbstractAction
{
    /**
     * @return string
     */
    public static function getInternalName(): string
    {
        return 'cancel';
    }

    /**
     * @return string
     */
    public static function getName(): string
    {
        return 'Отменить';
    }

    /**
     * @return string
     */
    public function getViewAvailableButton(): string
    {
        return '<a href="' .
            Url::toRoute([
                'task-actions/cancel-task',
                'taskId' => $this->task->id
            ]) .
            '" class="button button--pink action-btn"
            data-bs-toggle="modal"
            data-bs-target="#cancellation-form"
            data-action="' .
            static::getInternalName() . '">' .
            static::getName() . '</a>';
    }

    public function getAvailableWidget()
    {
        return Yii::$app->user->identity->userRole->role === 'client' ? CancellationWidget::widget([]) : '';
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
