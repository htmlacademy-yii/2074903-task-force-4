<?php

Yii::$container->set(
    \omarinina\application\services\respond\interfaces\RespondStatusAddInterface::class,
    \omarinina\application\services\respond\RespondStatusAddService::class
);

Yii::$container->set(
    \omarinina\application\services\respond\interfaces\RespondCreateInterface::class,
    \omarinina\application\services\respond\RespondCreateService::class
);
