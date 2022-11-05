<?php

declare(strict_types=1);

use app\widgets\TaskWidget;
use yii\widgets\Menu;
use omarinina\infrastructure\constants\UserRoleConstants;
use omarinina\infrastructure\constants\TaskStatusConstants;

/** @var yii\web\View $this */
/** @var omarinina\domain\models\task\Tasks[] $tasks */
/** @var string $title */


?>

<div class="main-content container">
    <div class="left-menu">
        <h3 class="head-main head-task">Мои задания</h3>
            <?php if (Yii::$app->user->identity->role === UserRoleConstants::ID_CLIENT_ROLE) : ?>
                <?php echo Menu::widget([
                    'items' => [
                        [
                            'label' => TaskStatusConstants::CLIENT_TASK_FILTERS[0]['name'],
                            'url' => [
                                TaskStatusConstants::CLIENT_TASK_FILTERS[0]['url'],
                                'status' => TaskStatusConstants::CLIENT_TASK_FILTERS[0]['status']
                            ],
                            'active' => Yii::$app->request->url === '/tasks/mine' ||
                                Yii::$app->request->url === '/tasks/mine?status=1'
                        ],
                        [
                            'label' => TaskStatusConstants::CLIENT_TASK_FILTERS[1]['name'],
                            'url' => [
                                TaskStatusConstants::CLIENT_TASK_FILTERS[1]['url'],
                                'status' => TaskStatusConstants::CLIENT_TASK_FILTERS[1]['status']
                            ]
                        ],
                        [
                            'label' => TaskStatusConstants::CLIENT_TASK_FILTERS[2]['name'],
                            'url' => [
                                TaskStatusConstants::CLIENT_TASK_FILTERS[2]['url'],
                                'status' => TaskStatusConstants::CLIENT_TASK_FILTERS[2]['status']
                            ]
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
                ]) ?>
            <?php elseif (Yii::$app->user->identity->role === UserRoleConstants::ID_EXECUTOR_ROLE) : ?>
                <?php echo Menu::widget([
                    'items' => [
                        [
                            'label' => TaskStatusConstants::EXECUTOR_TASK_FILTERS[0]['name'],
                            'url' => [
                                TaskStatusConstants::EXECUTOR_TASK_FILTERS[0]['url'],
                                'status' => TaskStatusConstants::EXECUTOR_TASK_FILTERS[0]['status']
                            ],
                            'active' => Yii::$app->request->url === '/tasks/mine' ||
                                Yii::$app->request->url === '/tasks/mine?status=3'
                        ],
                        [
                            'label' => TaskStatusConstants::EXECUTOR_TASK_FILTERS[1]['name'],
                            'url' => [
                                TaskStatusConstants::EXECUTOR_TASK_FILTERS[1]['url'],
                                'status' => TaskStatusConstants::EXECUTOR_TASK_FILTERS[1]['status']
                            ]
                        ],
                        [
                            'label' => TaskStatusConstants::EXECUTOR_TASK_FILTERS[2]['name'],
                            'url' => [
                                TaskStatusConstants::EXECUTOR_TASK_FILTERS[2]['url'],
                                'status' => TaskStatusConstants::EXECUTOR_TASK_FILTERS[2]['status']
                            ]
                        ],
                    ],
                    'options' => [
                        'class' => 'side-menu-list'
                    ],
                    'itemOptions' => [
                        'class' => 'side-menu-item'],
                    'linkTemplate' => '<a href="{url}" class="link link--nav">{label}</a>',
                    'activeCssClass' => 'side-menu-item--active'
                ]) ?>
            <?php endif; ?>
    </div>
    <div class="left-column left-column--task">
        <h3 class="head-main head-regular"><?= $title ?></h3>
        <?php if (!$tasks) : ?>
            <p>У вас пока нет заданий.</p>
        <?php endif; ?>
        <?php foreach ($tasks as $task) : ?>
            <?= TaskWidget::widget(['task' => $task]) ?>
        <?php endforeach; ?>
    </div>
</div>
