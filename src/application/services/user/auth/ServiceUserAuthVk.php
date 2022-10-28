<?php

namespace omarinina\application\services\user\auth;

use yii\authclient\clients\VKontakte;
use yii\authclient\Collection;
use Yii;
use yii\base\InvalidConfigException;

class ServiceUserAuthVk
{
    /**
     * @return VKontakte
     * @throws InvalidConfigException
     */
    public static function getVkClientOAuth() : VKontakte
    {
        /** @var Collection $collectionClientsOAuth */
        $collectionClientsOAuth = Yii::$app->get('authClientCollection');

        /** @var VKontakte $vkClientOAuth */
        $vkClientOAuth = $collectionClientsOAuth->getClient('vkontakte');

        return $vkClientOAuth;
    }
}
