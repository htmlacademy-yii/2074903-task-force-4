<?php declare(strict_types=1);

namespace omarinina\domain\actions;

use omarinina\domain\models\user\Users;
use yii\helpers\Url;
use Yii;
use app\widgets\ResponseWidget;

class RespondAction extends AbstractAction
{
    /**
     * @return string
     */
    public static function getInternalName(): string
    {
        return 'respond';
    }

    /**
     * @return string
     */
    public static function getName(): string
    {
        return 'Откликнуться';
    }

    /**
     * @return string
     */
    public function getViewAvailableButton(): string
    {
        return '<a href="' .
            Url::toRoute([
                'task-actions/respond-task',
                'taskId' => $this->task->id
            ]) .
            '" class="button button--blue action-btn"
            data-bs-toggle="modal"
            data-bs-target="#response-form"
            data-action="' .
            static::getInternalName() . '">' .
            static::getName() . '</a>';
    }

    public function getAvailableWidget()
    {
        return Yii::$app->user->identity->userRole->role === 'executor' ? ResponseWidget::widget([]) : '';
    }

    /**
     * @param int $idUser
     * @return bool
     */
    public function isAvailableForUser(int $idUser): bool
    {
        if (!$this->task->getResponds()->where(['executorId' => $idUser])->one()) {
            return Users::findOne($idUser)->userRole->role === 'executor';
        }
        return false;
    }
}
