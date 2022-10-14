<?php

/** @var yii\web\View $this */
/** @var string $content */

use yii\bootstrap5\Html;
use yii\helpers\Url;

\app\assets\BasicAsset::register($this);
?>

<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->sourceLanguage ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>

<body>
<?php $this->beginBody() ?>

<header class="page-header">
    <nav class="main-nav">
        <a href='#' class="header-logo">
            <img class="logo-image" src="/img/logotype.png" width=227 height=60 alt="taskforce">
        </a>
        <?php if (!Yii::$app->user->isGuest): ?>
        <div class="nav-wrapper">
            <ul class="nav-list">
                <li class="list-item list-item--active">
                    <a href="<?= Url::to(['tasks/index']) ?>" class="link link--nav" >Новое</a>
                </li>
                <li class="list-item">
                    <a href="#" class="link link--nav" >Мои задания</a>
                </li>
                <li class="list-item">
                    <a href="#" class="link link--nav" >Создать задание</a>
                </li>
                <li class="list-item">
                    <a href="#" class="link link--nav" >Настройки</a>
                </li>
            </ul>
        </div>
        <?php endif; ?>
    </nav>
    <?php if (!Yii::$app->user->isGuest): ?>
    <div class="user-block">
        <a href="#">
            <img class="user-photo" src="/img/man-glasses.png" width="55" height="55" alt="Аватар">
        </a>
        <div class="user-menu">
            <p class="user-name">Василий</p>
            <div class="popup-head">
                <ul class="popup-menu">
                    <li class="menu-item">
                        <a href="#" class="link">Настройки</a>
                    </li>
                    <li class="menu-item">
                        <a href="#" class="link">Связаться с нами</a>
                    </li>
                    <li class="menu-item">
                        <a href="#" class="link">Выход из системы</a>
                    </li>

                </ul>
            </div>
        </div>
        <?php else: ?>
        <div class="header__account--index">
            <a href="#" class="header__account-enter open-modal" data-for="enter-form">
                <span>Вход</span></a>
            или
            <a href="<?= Url::to(['registration/index']) ?>" class="header__account-registration">
                Регистрация
            </a>
        </div>
        <?php endif; ?>
    </div>
</header>

<main>
    <div class="main-container">
        <?= $content ?>
    </div>
</main>

<?php if (isset($this->blocks['pop-ups'])) : ?>
    <?= $this->blocks['pop-ups'] ?>
<?php endif; ?>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
