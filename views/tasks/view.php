<?php
/* @var $this View */
/** @var omarinina\domain\models\task\Tasks $currentTask */
/** @var omarinina\domain\models\task\Responds[] $responds */

use yii\web\View;
use yii\helpers\Url;
use omarinina\domain\models\user\Users;
use app\widgets\DenialWidget;

$this->registerJsFile('js/main.js');
?>
<div class="main-content container">
    <div class="left-column">
        <div class="head-wrapper">
            <h3 class="head-main"><?= $currentTask->name; ?></h3>
            <p class="price price--big"><?= $currentTask->budget; ?> ₽</p>
        </div>
        <p class="task-description"><?= $currentTask->description; ?></p>
        <?php if ($currentTask->getAvailableActions(\Yii::$app->user->id)) : ?>
            <?= $currentTask->getAvailableActions(\Yii::$app->user->id)->getViewAvailableButton($currentTask) ?>
        <?php endif; ?>
        <?php if (isset($currentTask->city->name)) : ?>
        <div class="task-map">
            <img class="map" src="/img/map.png"  width="725" height="346" alt="Новый арбат, 23, к. 1">
            <p class="map-address town"><?= $currentTask->city->name; ?></p>
            <p class="map-address">Новый арбат, 23, к. 1</p>
        </div>
        <?php endif; ?>
        <?php if (isset($responds)) : ?>
        <h4 class="head-regular">Отклики на задание</h4>
            <?php foreach ($responds as $respond) : ?>
        <div class="response-card">
            <img class="customer-photo"
                 src="<?= $respond->executor->avatarSrc ?>"
                 width="146" height="156" alt="Фото заказчиков">
            <div class="feedback-wrapper">
                <a href="<?= Url::to(['profile/view', 'id' => $respond->executor->id]) ?>"
                   class="link link--block link--big">
                    <?= $respond->executor->name ?></a>
                <div class="response-wrapper">
                    <div class="stars-rating small">
                        <?= str_repeat(
                            '<span class="fill-star">&nbsp;</span>',
                            round(
                                Users::findOne($respond->executor->id)->getExecutorRating()
                            )
                        ) ?>
                        <?= str_repeat(
                            '<span>&nbsp;</span>',
                            Users::MAX_RATING - round(
                                Users::findOne($respond->executor->id)->getExecutorRating()
                            )
                        ) ?>
                    </div>
                    <p class="reviews">
                        <?= \morphos\Russian\pluralize(
                            Users::findOne($respond->executor->id)->getCountReviews(),
                            'отзыв'
                        ) ?></p>
                </div>
                <p class="response-message">
                    <?= $respond->comment ?>
                </p>

            </div>

            <div class="feedback-wrapper">
                <p class="info-text">
                    <span class="current-time"><?= $respond->countTimeAgoPost($respond->createAt) ?>
                    </span> назад</p>
                <p class="price price--small"><?= $respond->price ?> ₽</p>
            </div>
                <?php if (!$respond->status && \Yii::$app->user->id === $currentTask->clientId) : ?>
            <div class="button-popup">
                <a href="<?= Url::toRoute([
                    'task-actions/accept-respond',
                    'respondId' => $respond->id
                ]) ?>" class="button button--blue button--small">Принять</a>
                <a href="<?= Url::to([
                    'task-actions/refuse-respond',
                    'respondId' => $respond->id
                ]) ?>" class="button button--orange button--small">Отказать</a>
            </div>
                <?php endif; ?>
        </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
    <div class="right-column">
        <div class="right-card black info-card">
            <h4 class="head-card">Информация о задании</h4>
            <dl class="black-list">
                <dt>Категория</dt>
                <dd><?= $currentTask->category->name ?></dd>
                <dt>Дата публикации</dt>
                <dd><?= $currentTask->countTimeAgoPost($currentTask->createAt) ?> назад</dd>
                <dt>Срок выполнения</dt>
                <dd><?= Yii::$app->formatter->asDate($currentTask->expiryDate, 'dd MMMM, HH:mm') ?></dd>
                <dt>Статус</dt>
                <dd><?= $currentTask->taskStatus->name ?></dd>
            </dl>
        </div>
        <div class="right-card white file-card">
            <h4 class="head-card">Файлы задания</h4>
            <ul class="enumeration-list">
                <li class="enumeration-item">
                    <a href="#" class="link link--block link--clip">my_picture.jpg</a>
                    <p class="file-size">356 Кб</p>
                </li>
                <li class="enumeration-item">
                    <a href="#" class="link link--block link--clip">information.docx</a>
                    <p class="file-size">12 Кб</p>
                </li>
            </ul>
        </div>
    </div>
</div>

<?= DenialWidget::widget([]) ?>

<?php $this->beginBlock('pop-ups'); ?>

<!--<section class="pop-up pop-up--refusal pop-up--close">-->
<!--    <div class="pop-up--wrapper">-->
<!--        <h4>Отказ от задания</h4>-->
<!--        <p class="pop-up-text">-->
<!--            <b>Внимание!</b><br>-->
<!--            Вы собираетесь отказаться от выполнения этого задания.<br>-->
<!--            Это действие плохо скажется на вашем рейтинге и увеличит счетчик проваленных заданий.-->
<!--        </p>-->
<!--        <a class="button button--pop-up button--orange">Отказаться</a>-->
<!--        <div class="button-container">-->
<!--            <button class="button--close" type="button">Закрыть окно</button>-->
<!--        </div>-->
<!--    </div>-->
<!--</section>-->
<section class="pop-up pop-up--completion pop-up--close">
    <div class="pop-up--wrapper">
        <h4>Завершение задания</h4>
        <p class="pop-up-text">
            Вы собираетесь отметить это задание как выполненное.
            Пожалуйста, оставьте отзыв об исполнителе и отметьте отдельно, если возникли проблемы.
        </p>
        <div class="completion-form pop-up--form regular-form">
            <form>
                <div class="form-group">
                    <label class="control-label" for="completion-comment">Ваш комментарий</label>
                    <textarea id="completion-comment"></textarea>
                </div>
                <p class="completion-head control-label">Оценка работы</p>
                <div class="stars-rating big active-stars"><span>&nbsp;</span><span>&nbsp;</span><span>&nbsp;</span><span>&nbsp;</span><span>&nbsp;</span></div>
                <input type="submit" class="button button--pop-up button--blue" value="Завершить">
            </form>
        </div>
        <div class="button-container">
            <button class="button--close" type="button">Закрыть окно</button>
        </div>
    </div>
</section>
<section class="pop-up pop-up--act_response pop-up--close">
    <div class="pop-up--wrapper">
        <h4>Добавление отклика к заданию</h4>
        <p class="pop-up-text">
            Вы собираетесь оставить свой отклик к этому заданию.
            Пожалуйста, укажите стоимость работы и добавьте комментарий, если необходимо.
        </p>
        <div class="addition-form pop-up--form regular-form">
            <form>
                <div class="form-group">
                    <label class="control-label" for="addition-comment">Ваш комментарий</label>
                    <textarea id="addition-comment"></textarea>
                </div>
                <div class="form-group">
                    <label class="control-label" for="addition-price">Стоимость</label>
                    <input id="addition-price" type="text">
                </div>
                <input type="submit" class="button button--pop-up button--blue" value="Завершить">
            </form>
        </div>
        <div class="button-container">
            <button class="button--close" type="button">Закрыть окно</button>
        </div>
    </div>
</section>
<div class="overlay"></div>

<?php $this->endBlock(); ?>
