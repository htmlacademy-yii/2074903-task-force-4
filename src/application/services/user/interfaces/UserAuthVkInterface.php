<?php

namespace omarinina\application\services\user\interfaces;

use yii\authclient\clients\VKontakte;

interface UserAuthVkInterface
{
    /**
     * @param string $code
     * @param VKontakte $vkClient
     * @return VKontakte
     */
    public function applyAccessTokenForVk(string $code, VKontakte $vkClient) : VKontakte;
}
