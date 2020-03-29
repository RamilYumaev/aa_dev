<?php
/* @var $model modules\dictionary\forms\DictCseSubjectForm */
/* @var $form yii\bootstrap\ActiveForm */

use yii\bootstrap\ActiveForm;
use yii\helpers\Html;
?>

<div class="box">
    <div class="box-body">
        <?php $form = ActiveForm::begin(['id'=> 'form-dict-post-education']); ?>
        <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
        <?= $form->field($model, 'min_mark')->textInput(['maxlength' => true]) ?>
        <?= $form->field($model, 'composite_discipline_status')->checkbox() ?>
        <?= $form->field($model, 'cse_status')->checkbox() ?>
        <?= $form->field($model, 'ais_id')->textInput(['maxlength' => true]) ?>
        <div class="form-group">
            <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
        </div>
        <?php ActiveForm::end(); ?>
    </div>
</div>
