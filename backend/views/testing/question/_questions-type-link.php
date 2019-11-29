<?php

use yii\helpers\Html;

?>
<div class="row">
    <div class="col-md-2 button dark-purple">
        <?= Html::a('со множественными правильными ответами', ['/testing/question/types/type-select']); ?>
    </div>
    <div class="col-md-2 button dark-purple">
        <?= Html::a('с одним правильным ответом', ['/testing/question/types/type-select-one']); ?>
    </div>
    <div class="col-md-1 button dark-purple">
        <?= Html::a('на соответствие', ['/testing/question/types/type-matching']); ?>
    </div>
    <div class="col-md-1 button dark-purple">
        <?= Html::a('с кратким ответом', ['/testing/question/types/type-answer-short']); ?>
    </div>
    <div class="col-md-2 button dark-purple">
        <?= Html::a('с развернутым ответом', ['/testing/question/types/type-answer-detailed']); ?>
    </div>
    <div class="col-md-1 button dark-purple">
        <?= Html::a('с загрузкой файла', ['/testing/question/types/type-file']); ?>
    </div>
<!--    <div class="col-md-2">-->
<!--        --><?//= Html::a('с вложенными ответами', ['/testing/question/types/type-cloze']); ?>
<!--    </div>-->
</div>