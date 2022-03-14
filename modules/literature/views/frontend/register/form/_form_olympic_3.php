<?php

/* @var $form yii\bootstrap\ActiveForm */
/* @var $model modules\literature\models\LiteratureOlympic */

use kartik\date\DatePicker;
use kartik\file\FileInput;
use modules\entrant\helpers\DateFormatHelper;
use yii\bootstrap\ActiveForm;
use yii\helpers\Html; ?>
<?php $form = ActiveForm::begin(['id'=> 'form-reg']); ?>
<?= $form->field($model, 'size')->dropDownList($model->getSizes())?>
<div class="col-md-4">
    <?= $form->field($model, 'is_allergy')->checkbox()?>
    <?= $form->field($model, 'note_allergy')->textarea()?>
</div>
<div class="col-md-4">
    <?= $form->field($model, 'is_need_conditions')->checkbox()?>
    <?= $form->field($model, 'note_conditions')->textarea() ?>
</div>
<div class="col-md-4">
    <?= $form->field($model, 'is_voz')->checkbox()?>
    <?= $form->field($model, 'note_special')->textarea() ?>
</div>
<div class="col-md-12">
    <div class="form-group">
        <?= Html::submitButton('Далее', ['class' => 'btn btn-success btn-lg pull-right']) ?>
    </div>
</div>
<?php ActiveForm::end(); ?>






