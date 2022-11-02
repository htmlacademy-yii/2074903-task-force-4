<?php

namespace omarinina\application\services\file\parse;

use omarinina\domain\models\Files;
use yii\web\ServerErrorHttpException;
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
            $avatar->saveAs('@webroot/uploads/' . $name);

            return '/uploads/' . $name;
        }
        return null;
    }
}
