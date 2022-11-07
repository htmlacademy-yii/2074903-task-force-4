<?php

namespace omarinina\application\services\file\interfaces;

use yii\web\UploadedFile;

interface FileParseInterface
{
    /**
     * @param UploadedFile|null $avatar
     * @return string|null
     */
    public function parseAvatarFile(?UploadedFile $avatar = null) : ?string;

    /**
     * @param string|null $urlAvatarVk
     * @return string|null
     */
    public function parseAvatarVkFile(?string $urlAvatarVk = null) : ?string;
}
