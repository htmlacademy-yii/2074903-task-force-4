<?php

namespace omarinina\domain\traits;

use Yii;
use DateTime;
use function morphos\Russian\pluralize;

trait TimeCounter
{
    /**
     * @return string
     * @throws \Exception
     */
    public function countTimeAgoPost():string
    {
        //$createAt is received from every used model
        $unixCreateAt = Yii::$app->formatter->asTimestamp($this->createAt);
        $unixNow = Yii::$app->formatter->asTimestamp(new DateTime('now'));
        $diff = $unixNow - $unixCreateAt;

        if ($diff / 86400 >= 1) {
            return pluralize(floor($diff / 86400), 'день');
        } elseif ($diff / 3600 >= 1) {
            return pluralize(floor($diff / 3600), 'час');
        }
        return pluralize(floor($diff / 60), 'минута');
    }
}
