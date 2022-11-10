<?php

declare(strict_types=1);

namespace omarinina\domain\actions;

use omarinina\domain\models\user\Users;
use omarinina\infrastructure\constants\UserRoleConstants;

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
        return '<a class="button button--blue action-btn"
            data-action="act_response">' .
            static::getName() . '</a>';
    }

    /**
     * @param int $idUser
     * @return bool
     */
    public function isAvailableForUser(int $idUser): bool
    {
        if (!$this->task->getResponds()->where(['executorId' => $idUser])->one()) {
            return Users::findOne($idUser)->role === UserRoleConstants::ID_EXECUTOR_ROLE;
        }
        return false;
    }
}
