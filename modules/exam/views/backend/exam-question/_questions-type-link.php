<?php

use testing\helpers\TestQuestionHelper;
use yii\helpers\Html;
?>
<div class="row">
    <div class="col-md-12">
        <?= Html::a('Выбрать вариант(ы)', ['create', 'type' =>TestQuestionHelper::TYPE_SELECT], [ 'class'=>'btn btn-success']); ?>
        <?= Html::a('Выбрать вариант', ['create', 'type' =>TestQuestionHelper::TYPE_SELECT_ONE], [ 'class'=>'btn btn-success']); ?>
        <?= Html::a('Сопоставить', ['create', 'type' =>TestQuestionHelper::TYPE_MATCHING], [ 'class'=>'btn btn-success']); ?>
        <?= Html::a('Краткий ответ', ['create', 'type' =>TestQuestionHelper::TYPE_ANSWER_SHORT], [ 'class'=>'btn btn-success']); ?>
        <?= Html::a('Развернутый ответ', ['create', 'type' =>TestQuestionHelper::TYPE_ANSWER_DETAILED], [ 'class'=>'btn btn-success']); ?>
        <? /* Html::a('Загрузка файла', ['create', 'type' =>TestQuestionHelper::TYPE_FILE], [ 'class'=>'btn btn-success']); */ ?>
        <?= Html::a('Вложенные ответы', ['create', 'type' =>TestQuestionHelper::TYPE_CLOZE], [ 'class'=>'btn btn-success']); ?>
    </div>
</div>