<?php
use yii\helpers\Html;

?>
<div class="row">
    <div class="col-md-12">
        <?= Html::a('Выбрать вариант(ы)', ['type-select'], [ 'class'=>'btn btn-success']); ?>
        <?= Html::a('Выбрать вариант', ['type-select-one'], [ 'class'=>'btn btn-success']); ?>
        <?= Html::a('Сопаставить', ['type-matching'], [ 'class'=>'btn btn-success']); ?>
        <?= Html::a('Краткий ответ', ['type-answer-short'], [ 'class'=>'btn btn-success']); ?>
        <?= Html::a('Развернутый ответ', ['type-answer-detailed'], [ 'class'=>'btn btn-success']); ?>
        <?= Html::a('Загрузка файла', ['type-files'], [ 'class'=>'btn btn-success']); ?>
        <?= Html::a('Вложенные ответы', ['type-cloze'], [ 'class'=>'btn btn-success']); ?>
    </div>
</div>
