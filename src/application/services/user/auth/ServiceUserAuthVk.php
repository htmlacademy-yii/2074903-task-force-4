<?php

declare(strict_types=1);

namespace omarinina\application\services\user\auth;

use yii\authclient\clients\VKontakte;
use yii\authclient\Collection;
use Yii;
use yii\base\InvalidConfigException;
use yii\web\HttpException;

class ServiceUserAuthVk
{
    /**
     * @param string $code
     * @param VKontakte $vkClient
     * @return VKontakte
     * @throws HttpException
     */
    public static function applyAccessTokenForVk(string $code, VKontakte $vkClient) : VKontakte
    {
        $token = $vkClient->fetchAccessToken($code);
        $requestOAuth = $vkClient->createRequest();

        $vkClient->applyAccessTokenToRequest($requestOAuth, $token);

        return $vkClient;
    }
}
