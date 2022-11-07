<?php

Yii::$container->set(
    \omarinina\application\services\respond\interfaces\RespondStatusAddInterface::class,
    \omarinina\application\services\respond\RespondStatusAddService::class
);

Yii::$container->set(
    \omarinina\application\services\respond\interfaces\RespondCreateInterface::class,
    \omarinina\application\services\respond\RespondCreateService::class
);

Yii::$container->set(
    \omarinina\application\services\file\interfaces\FileParseInterface::class,
    \omarinina\application\services\file\FileParseService::class
);

Yii::$container->set(
    \omarinina\application\services\file\interfaces\FileSaveInterface::class,
    \omarinina\application\services\file\FileSaveService::class
);
