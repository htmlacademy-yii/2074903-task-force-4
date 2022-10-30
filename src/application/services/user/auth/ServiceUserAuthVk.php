<?php

namespace omarinina\application\services\user\auth;

use yii\authclient\clients\VKontakte;
use yii\authclient\Collection;
use Yii;
use yii\base\InvalidConfigException;
use yii\web\HttpException;

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

    /**
     * @param string $code
     * @return VKontakte
     * @throws InvalidConfigException
     * @throws HttpException
     */
    public static function applyAccessTokenForVk(string $code) : VKontakte
    {
        $vkClient = static::getVkClientOAuth();
        $token = $vkClient->fetchAccessToken($code);
        $requestOAuth = $vkClient->createRequest();

        $vkClient->applyAccessTokenToRequest($requestOAuth, $token);

        return $vkClient;
    }
}
