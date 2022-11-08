<?php

declare(strict_types=1);

namespace app\controllers;

use omarinina\domain\models\Files;
use yii\web\NotFoundHttpException;
use yii\web\Response;
use Yii;

class FileController extends SecurityController
{
    /**
     * @param int $fileId
     * @return Response|string
     */
    public function actionDownload(int $fileId) : Response|string
    {
        try {
            if ($fileId) {
                $file = Files::findOne($fileId);
                if (!$file) {
                    throw new NotFoundHttpException('File is not found', 404);
                }

                $filePath = Yii::getAlias('@webroot') . $file->fileSrc;
                return Yii::$app->response->sendFile($filePath);
            } else {
                throw new NotFoundHttpException('File is not found', 404);
            }
        } catch (NotFoundHttpException $e) {
            return $e->getMessage();
        } catch (\Throwable $e) {
            Yii::$app->errorHandler->logException($e);
            return 'Something wrong. Sorry, please, try again later';
        }
    }
}
