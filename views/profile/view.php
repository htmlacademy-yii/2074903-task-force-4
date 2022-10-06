<?php
/** @var yii\web\View $this */
/** @var omarinina\domain\models\user\Users $currentUser */
/** @var omarinina\infrastructure\statistic\ExecutorStatistic $executorStatistic */

use omarinina\infrastructure\statistic\ExecutorStatistic;
use yii\helpers\Url;
use Yii;
?>
<div class="main-content container">
    <div class="left-column">
        <h3 class="head-main"><?= $currentUser->name ?></h3>
        <div class="user-card">
            <div class="photo-rate">
                <img class="card-photo" src="<?= $currentUser->avatarSrc ?>" width="191" height="190" alt="Фото пользователя">
                <div class="card-rate">
                    <div class="stars-rating big">
                        <?= str_repeat('<span class="fill-star">&nbsp;</span>', round($executorStatistic->getExecutorRating())) ?>
                        <?= str_repeat('<span>&nbsp;</span>', ExecutorStatistic::MAX_RATING - round($executorStatistic->getExecutorRating())) ?>
                    </div>
                    <span class="current-rate"><?= $executorStatistic->getExecutorRating() ?></span>
                </div>
            </div>
            <p class="user-description">
                <?= $currentUser->bio ?>
            </p>
        </div>
        <div class="specialization-bio">
            <div class="specialization">
                <p class="head-info">Специализации</p>
                <ul class="special-list">
                    <?php foreach ($currentUser->executorCategories as $category): ?>
                    <li class="special-item">
                        <a href="#" class="link link--regular"><?= $category->name ?></a>
                    </li>
                    <?php endforeach; ?>
                </ul>
            </div>
            <div class="bio">
                <p class="head-info">Био</p>
                <p class="bio-info"><span class="country-info">Россия</span>,
                    <span class="town-info"><?= $currentUser->userCity->name ?></span>,
                    <span class="age-info"><?= \morphos\Russian\pluralize(
                        round(Yii::$app->formatter->asTimestamp($currentUser->birthDate) / (365 * 24 * 60 * 60)),
                        'год') ?></span>
                </p>
            </div>
        </div>
        <h4 class="head-regular">Отзывы заказчиков</h4>
        <?php foreach ($currentUser->executorReviews as $executorReview): ?>
        <div class="response-card">
            <img class="customer-photo" src="<?= $executorReview->client->avatarSrc ?>" width="120" height="127" alt="Фото заказчиков">
            <div class="feedback-wrapper">
                <p class="feedback"><?= $executorReview->comment ?></p>
                <p class="task">Задание «<a href="<?= Url::to(['tasks/view', 'id' => $executorReview->taskId]) ?>" class="link link--small"><?= $executorReview->task->name ?></a>» <?= $executorReview->task->taskStatus->name ?></p>
            </div>
            <div class="feedback-wrapper">
                <div class="stars-rating small">
                    <?= str_repeat('<span class="fill-star">&nbsp;</span>', round($executorReview->score)) ?><?= str_repeat('<span>&nbsp;</span>', ExecutorStatistic::MAX_RATING - round($executorReview->score)) ?>
                </div>
                <p class="info-text"><span class="current-time"><?= $executorReview->countTimeAgoPost() ?></span> назад</p>
            </div>
        </div>
        <?php endforeach; ?>

    </div>
    <div class="right-column">
        <div class="right-card black">
            <h4 class="head-card">Статистика исполнителя</h4>
            <dl class="black-list">
                <dt>Всего заказов</dt>
                <dd><?= $executorStatistic->getCountDoneTasks() ?> выполнено, <?= $executorStatistic->getCountFailedTasks() ?> провалено</dd>
                <dt>Место в рейтинге</dt>
                <dd><?= $executorStatistic->getExecutorPlace() ?> место</dd>
                <dt>Дата регистрации</dt>
                <dd><?= $executorStatistic->getExecutorCreateAt() ?></dd>
                <dt>Статус</dt>
                <dd><?= $executorStatistic->getExecutorCurrentStatus() ?></dd>
            </dl>
        </div>
        <div class="right-card white">
            <h4 class="head-card">Контакты</h4>
            <ul class="enumeration-list">
                <li class="enumeration-item">
                    <a href="#" class="link link--block link--phone"><?= $currentUser->phone ?></a>
                </li>
                <li class="enumeration-item">
                    <a href="#" class="link link--block link--email"><?= $currentUser->email ?></a>
                </li>
                <li class="enumeration-item">
                    <a href="#" class="link link--block link--tg"><?= $currentUser->telegram ?></a>
                </li>
            </ul>
        </div>
    </div>
</div>
