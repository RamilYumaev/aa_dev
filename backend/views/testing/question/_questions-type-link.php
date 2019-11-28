<?php
use yii\helpers\Html;
?>
<div class="row">
    <div class="col-md-12">
        <?= Html::a('Выбрать вариант(ы)', ['/testing/question/types/type-select'], [ 'class'=>'btn btn-success']); ?>
        <?= Html::a('Выбрать вариант', ['/testing/question/types/type-select-one'], [ 'class'=>'btn btn-success']); ?>
        <?= Html::a('Сопоставить', ['/testing/question/types/type-matching'], [ 'class'=>'btn btn-success']); ?>
        <?= Html::a('Краткий ответ', ['/testing/question/types/type-answer-short'], [ 'class'=>'btn btn-success']); ?>
        <?= Html::a('Развернутый ответ', ['/testing/question/types/type-answer-detailed'], [ 'class'=>'btn btn-success']); ?>
        <?= Html::a('Загрузка файла', ['/testing/question/types/type-file'], [ 'class'=>'btn btn-success']); ?>
        <?= Html::a('Вложенные ответы', ['/testing/question/types/type-cloze'], [ 'class'=>'btn btn-success']); ?>
    </div>
</div>