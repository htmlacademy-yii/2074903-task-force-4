<?php

declare(strict_types=1);

namespace omarinina\application\services\file\save;

use omarinina\domain\models\Files;
use yii\web\ServerErrorHttpException;
use yii\web\UploadedFile;

class ServiceFileSave
{
    /**
     * @param UploadedFile $file
     * @return Files|null
     * @throws ServerErrorHttpException
     */
    public static function saveNewFile(UploadedFile $file) : ?Files
    {
        $savedFile = new Files();
        $name = uniqid('upload') . '.' . $file->getExtension();
        $file->saveAs('@webroot/uploads/' . $name);
        $savedFile->fileSrc = '/uploads/' . $name;

        if (!$savedFile->save(false)) {
            throw new ServerErrorHttpException(
                'Your data has not been recorded, please try again later',
                500
            );
        }

        return $savedFile;
    }
}
