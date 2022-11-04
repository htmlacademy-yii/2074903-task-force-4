<?php

declare(strict_types=1);

use app\widgets\assets\ProfileNavigationWidgetAsset;
use yii\widgets\Menu;

ProfileNavigationWidgetAsset::register($this);
$user = Yii::$app->user->identity;

?>

    <div class="left-menu left-menu--edit">
        <h3 class="head-main head-task">Настройки</h3>

<?php

echo Menu::widget([
    'items' => [
        [
            'label' => 'Мой профиль',
            'url' => ['profile/edit'],
        ],
        [
            'label' => $user->vkId ? null : 'Безопасность',
            'url' => $user->vkId ? null : ['profile/security'],
        ],
    ],
    'options' => [
        'class' => 'side-menu-list'
    ],
    'itemOptions' => [
        'class' => 'side-menu-item'],
    'linkTemplate' => '<a href="{url}" class="link link--nav">{label}</a>',
    'activeCssClass' => 'side-menu-item--active',
    'activateItems' => true
]);

?>

    </div>
