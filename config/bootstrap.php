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

Yii::$container->set(
    \omarinina\application\services\file\interfaces\FileTaskRelationsInterface::class,
    \omarinina\application\services\file\FileTaskRelationsService::class
);

Yii::$container->set(
    \omarinina\application\services\review\interfaces\ReviewCreateInterface::class,
    \omarinina\application\services\review\ReviewCreateService::class
);

Yii::$container->set(
    \omarinina\application\services\task\interfaces\TaskCreateInterface::class,
    \omarinina\application\services\task\TaskCreateService::class
);

Yii::$container->set(
    \omarinina\application\services\task\interfaces\TaskFilterInterface::class,
    \omarinina\application\services\task\TaskFilterService::class
);

Yii::$container->set(
    \omarinina\application\services\user\interfaces\UserCategoriesUpdateInterface::class,
    \omarinina\application\services\user\UserCategoriesUpdateService::class
);

Yii::$container->set(
    \omarinina\application\services\user\interfaces\UserShowInterface::class,
    \omarinina\application\services\user\UserShowService::class
);

Yii::$container->set(
    \omarinina\application\services\user\interfaces\UserCreateInterface::class,
    \omarinina\application\services\user\UserCreateService::class
);

Yii::$container->set(
    \omarinina\application\services\user\interfaces\UserAuthVkInterface::class,
    \omarinina\application\services\user\UserAuthVkVkService::class
);
