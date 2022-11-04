<?php
/** @var yii\web\View $this */
/** @var omarinina\domain\models\user\Users $currentUser */

use omarinina\domain\models\user\Users;
use yii\helpers\Url;
use Yii;
use omarinina\infrastructure\constants\UserRoleConstants;
use DateTime;
use omarinina\domain\models\task\Tasks;

if ($currentUser->birthDate) {
    $date = date_create($currentUser->birthDate);
    $interval = $date->diff(new DateTime('now'));
}

?>
<div class="main-content container">
    <div class="left-column">
        <h3 class="head-main"><?= $currentUser->name ?></h3>
        <div class="user-card">
            <div class="photo-rate">
                <img class="card-photo"
                     src="<?= $currentUser->avatarSrc ?>"
                     width="191" height="190" alt="Фото пользователя">
                <?php if ($currentUser->role === UserRoleConstants::ID_EXECUTOR_ROLE) : ?>
                <div class="card-rate">
                    <div class="stars-rating big">
                        <?= str_repeat(
                            '<span class="fill-star">&nbsp;</span>',
                            round($currentUser->getExecutorRating())
                        ) ?>
                        <?= str_repeat(
                            '<span>&nbsp;</span>',
                            Users::MAX_RATING - round($currentUser->getExecutorRating())
                        ) ?>
                    </div>
                    <span class="current-rate"><?= $currentUser->getExecutorRating() ?></span>
                </div>
                <?php endif; ?>
            </div>
            <p class="user-description">
                <?php if ($currentUser->bio) : ?>
                    <?= $currentUser->bio ?>
                <?php else : ?>
                    Здесь пока ничего нет
                <?php endif; ?>
            </p>
        </div>
        <div class="specialization-bio">
            <?php if ($currentUser->role === UserRoleConstants::ID_EXECUTOR_ROLE) : ?>
            <div class="specialization">
                <p class="head-info">Специализации </p>
                <ul class="special-list">
                    <?php if ($currentUser->executorCategories) : ?>
                        <?php foreach ($currentUser->executorCategories as $category) : ?>
                            <li class="special-item">
                                <a href="<?= Url::to(['tasks/index', 'category' => $category->id]) ?>"
                                   class="link link--regular"><?= $category->name ?></a>
                            </li>
                        <?php endforeach; ?>
                    <?php else : ?>
                        <p>Категории не выбраны</p>
                    <?php endif; ?>
                </ul>
            </div>
            <?php endif; ?>
            <div class="bio">
                <p class="head-info">Био</p>
                <p class="bio-info"><span class="country-info">Россия</span>,
                    <span class="town-info"><?= $currentUser->userCity->name ?></span>
                    <?php if ($currentUser->birthDate) : ?>
                        <span class="age-info">, <?= \morphos\Russian\pluralize($interval->y, 'год') ?></span>
                    <?php endif; ?>
                </p>
            </div>
        </div>
        <?php if ($currentUser->executorReviews) : ?>
        <h4 class="head-regular">Отзывы заказчиков</h4>
            <?php foreach ($currentUser->executorReviews as $executorReview) : ?>
        <div class="response-card">
            <img class="customer-photo"
                 src="<?= $executorReview->client->avatarSrc ?>"
                 width="120" height="127" alt="Фото заказчиков">
            <div class="feedback-wrapper">
                <p class="feedback"><?= $executorReview->comment ?></p>
                <p class="task">
                    Задание «
                    <a href="<?= Url::to(['tasks/view', 'id' => $executorReview->taskId]) ?>" class="link link--small">
                        <?= $executorReview->task->name ?></a>»
                    <?= $executorReview->task->taskStatus->name ?></p>
            </div>
            <div class="feedback-wrapper">
                <div class="stars-rating small">
                    <?= str_repeat(
                        '<span class="fill-star">&nbsp;</span>',
                        round($executorReview->score)
                    ) ?><?= str_repeat(
                        '<span>&nbsp;</span>',
                        Users::MAX_RATING - round($executorReview->score)
                    ) ?>
                </div>
                <p class="info-text">
                    <span class="current-time">
                        <?= $executorReview->countTimeAgoPost($executorReview->createAt) ?>
                    </span> назад</p>
            </div>
        </div>
            <?php endforeach; ?>
        <?php endif; ?>

    </div>
    <div class="right-column">
        <?php if ($currentUser->role === UserRoleConstants::ID_EXECUTOR_ROLE) : ?>
        <div class="right-card black">
            <h4 class="head-card">Статистика исполнителя</h4>
            <dl class="black-list">
                <dt>Всего заказов</dt>
                <dd><?= $currentUser->getCountDoneTasks() ?> выполнено,
                    <?= $currentUser->getCountFailedTasks() ?> провалено</dd>
                <dt>Место в рейтинге</dt>
                <dd><?= $currentUser->getExecutorPlace() ?> место</dd>
                <dt>Дата регистрации</dt>
                <dd><?= $currentUser->getExecutorCreateAt() ?></dd>
                <dt>Статус</dt>
                <dd><?= $currentUser->getExecutorCurrentStatus() ?></dd>
            </dl>
        </div>
        <?php endif; ?>
        <?php if (!$currentUser->hidden &&
            !Tasks::find()->where(['clientId' => $currentUser])->andWhere(['executorId' => Yii::$app->user->id])) : ?>
        <div class="right-card white">
            <h4 class="head-card">Контакты</h4>
            <ul class="enumeration-list">
                <?php if ($currentUser->phone) : ?>
                <li class="enumeration-item">
                    <a href="#" class="link link--block link--phone"><?= $currentUser->phone ?></a>
                </li>
                <?php endif; ?>
                <?php if ($currentUser->email) : ?>
                <li class="enumeration-item">
                    <a href="#" class="link link--block link--email"><?= $currentUser->email ?></a>
                </li>
                <?php endif; ?>
                <?php if ($currentUser->telegram) : ?>
                <li class="enumeration-item">
                    <a href="#" class="link link--block link--tg"><?= $currentUser->telegram ?></a>
                </li>
                <?php endif; ?>
            </ul>
        </div>
        <?php endif; ?>
    </div>
</div>
