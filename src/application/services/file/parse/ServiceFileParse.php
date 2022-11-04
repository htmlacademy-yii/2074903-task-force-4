<?php

declare(strict_types=1);

namespace omarinina\application\services\file\parse;

use yii\web\UploadedFile;

class ServiceFileParse
{
    /**
     * @param UploadedFile|null $avatar
     * @return string|null
     */
    public static function parseAvatarFile(?UploadedFile $avatar = null) : ?string
    {
        if ($avatar) {
            $name = uniqid('upload') . '.' . $avatar->getExtension();
            $avatar->saveAs('@webroot/uploads/avatars/' . $name);

            return '/uploads/avatars/' . $name;
        }
        return null;
    }
}
