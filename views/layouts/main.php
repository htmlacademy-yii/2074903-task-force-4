<?php

/** @var yii\web\View $this */
/** @var string $content */
/** @var omarinina\domain\models\user\Users $user */
$user = Yii::$app->user->identity;

use yii\bootstrap5\Html;
use yii\helpers\Url;
use yii\widgets\Menu;
use app\widgets\Alert;

\app\assets\BasicAsset::register($this);
?>

<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->sourceLanguage ?>">
<head>
    <?php $this->registerCsrfMetaTags()?>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>

<body>
<?php $this->beginBody() ?>

<header class="page-header">
    <nav class="main-nav">
        <a href='<?= Url::to(['tasks/index']) ?>' class="header-logo">
            <img class="logo-image" src="/img/logotype.png" width=227 height=60 alt="taskforce">
        </a>
        <?php if (!Yii::$app->user->isGuest) : ?>
        <div class="nav-wrapper">
            <?php echo Menu::widget([
                'items' => [
                    ['label' => 'Новое', 'url' => ['tasks/index']],
                    ['label' => 'Мои задания', 'url' => ['']],
                    ['label' => 'Создать задание', 'url' => ['tasks/create']],
                    ['label' => 'Настройки', 'url' => ['']]
                ],
                'options' => [
                    'class' => 'nav-list'
                ],
                'itemOptions' => [
                    'class' => 'list-item'],
                'linkTemplate' => '<a href="{url}" class="link link--nav">{label}</a>',
                'activeCssClass' => 'list-item--active'
]) ?>
        </div>
        <?php endif; ?>
    </nav>
    <?php if (!Yii::$app->user->isGuest) : ?>
    <div class="user-block">
        <a href="#">
            <img class="user-photo" src="/img/man-glasses.png" width="55" height="55" alt="Аватар">
        </a>
        <div class="user-menu">
            <p class="user-name"><?= $user->name ?></p>
            <div class="popup-head">
                <ul class="popup-menu">
                    <li class="menu-item">
                        <a href="#" class="link">Настройки</a>
                    </li>
                    <li class="menu-item">
                        <a href="#" class="link">Связаться с нами</a>
                    </li>
                    <li class="menu-item">
                        <a href="<?= Url::to(['site/logout']) ?>" class="link" data-method="post">Выход из системы</a>
                    </li>

                </ul>
            </div>
        </div>
    <?php endif; ?>
    </div>
</header>

<?= Alert::widget() ?>

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
