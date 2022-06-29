<?php

use testing\helpers\TestQuestionHelper;
use yii\helpers\Html;
?>
<div class="row">
    <div class="col-md-12">
        <?= Yii::$app->user->can("multiple-type") ?
            Html::a('Выбрать вариант(ы)', ['create', 'type' =>TestQuestionHelper::TYPE_SELECT], [ 'class'=>'btn btn-success']) : ""; ?>
        <?= Html::a('Легкий вопрос (да-нет)', ['create', 'type' =>TestQuestionHelper::TYPE_SELECT_ONE], [ 'class'=>'btn btn-success']); ?>
        <?= Html::a('Трудный вопрос (выбор 1-го правильного из 4-х возможных)', ['create', 'type' =>TestQuestionHelper::TYPE_SELECT_ONE], [ 'class'=>'btn btn-success']); ?>
        <?= Html::a('Трудный вопрос (на установление соответствия - однозначное сопоставление)', ['create', 'type' =>TestQuestionHelper::TYPE_MATCHING], [ 'class'=>'btn btn-success']); ?>
        <?= Html::a('Трудный вопрос (на установление соответствия - единый вариант)', ['create', 'type' =>TestQuestionHelper::TYPE_MATCHING_SAME], [ 'class'=>'btn btn-success']); ?>
        <?= Yii::$app->user->can("short-type") ?
            Html::a('Краткий ответ', ['create', 'type' => TestQuestionHelper::TYPE_ANSWER_SHORT], [ 'class'=>'btn btn-success']) : ""; ?>
        <?= Yii::$app->user->can("detailed-type") ?
            Html::a('Развернутый ответ', ['create', 'type' =>TestQuestionHelper::TYPE_ANSWER_DETAILED], [ 'class'=>'btn btn-success']) : ""; ?>
        <?= Yii::$app->user->can("file-type") ? Html::a('Трудный вопрос (загрузка файла)', ['create', 'type' =>TestQuestionHelper::TYPE_FILE], [ 'class'=>'btn btn-success']) :"" ; ?>
        <?= Html::a('Трудный вопрос (на заполнение пропусков)', ['create', 'type' =>TestQuestionHelper::TYPE_CLOZE], [ 'class'=>'btn btn-success']); ?>
    </div>
</div>