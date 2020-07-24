<?php

use testing\helpers\TestQuestionHelper;
use yii\helpers\Html;
?>
<div class="row">
    <div class="col-md-12">
        <?= Yii::$app->user->can("multiple-type") ?
            Html::a('Выбрать вариант(ы)', ['create', 'type' =>TestQuestionHelper::TYPE_SELECT], [ 'class'=>'btn btn-success']) : ""; ?>
        <?= Html::a('Тип 5.2.0 Легкий вопрос (да-нет)', ['create', 'type' =>TestQuestionHelper::TYPE_SELECT_ONE], [ 'class'=>'btn btn-success']); ?>
        <?= Html::a('Тип 5.2.1 Трудный вопрос (один из четырех)', ['create', 'type' =>TestQuestionHelper::TYPE_SELECT_ONE], [ 'class'=>'btn btn-success']); ?>
        <?= Html::a('Тип 5.2.2  Трудный вопрос (на установление соответствия)', ['create', 'type' =>TestQuestionHelper::TYPE_MATCHING], [ 'class'=>'btn btn-success']); ?>
        <?= Html::a('Тип 5.2.3 Трудный вопрос (на установление последовательности)', ['create', 'type' =>TestQuestionHelper::TYPE_MATCHING], [ 'class'=>'btn btn-success']); ?>
        <?= Yii::$app->user->can("short-type") ?
            Html::a('Краткий ответ', ['create', 'type' =>TestQuestionHelper::TYPE_ANSWER_SHORT], [ 'class'=>'btn btn-success']) : ""; ?>
        <?= Yii::$app->user->can("detailed-type") ?
            Html::a('Развернутый ответ', ['create', 'type' =>TestQuestionHelper::TYPE_ANSWER_DETAILED], [ 'class'=>'btn btn-success']) : ""; ?>
        <?php /* Html::a('Загрузка файла', ['create', 'type' =>TestQuestionHelper::TYPE_FILE], [ 'class'=>'btn btn-success']); */ ?>
        <?= Html::a('Тип 5.2.4. Трудный вопрос (на заполнение пропусков)', ['create', 'type' =>TestQuestionHelper::TYPE_CLOZE], [ 'class'=>'btn btn-success']); ?>
    </div>
</div>