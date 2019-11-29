<?php
use yii\helpers\Html;
?>
<div class="row">
    <div class="col-md-12">
        <?= Html::a('Выбрать вариант(ы)', ['/testing/question/types/type-select', 'olympic_id' => $olympic], [ 'class'=>'btn btn-success']); ?>
        <?= Html::a('Выбрать вариант', ['/testing/question/types/type-select-one', 'olympic_id' => $olympic], [ 'class'=>'btn btn-success']); ?>
        <?= Html::a('Сопоставить', ['/testing/question/types/type-matching', 'olympic_id' => $olympic ], [ 'class'=>'btn btn-success']); ?>
        <?= Html::a('Краткий ответ', ['/testing/question/types/type-answer-short', 'olympic_id' => $olympic], [ 'class'=>'btn btn-success']); ?>
        <?= Html::a('Развернутый ответ', ['/testing/question/types/type-answer-detailed', 'olympic_id' => $olympic], [ 'class'=>'btn btn-success']); ?>
        <?= Html::a('Загрузка файла', ['/testing/question/types/type-file','olympic_id' => $olympic], [ 'class'=>'btn btn-success']); ?>
        <?= Html::a('Вложенные ответы', ['/testing/question/types/type-cloze', 'olympic_id' => $olympic], [ 'class'=>'btn btn-success']); ?>
    </div>
</div>