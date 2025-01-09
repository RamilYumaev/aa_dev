<?php

use kartik\select2\Select2;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $specialTypeOlimpic \olympic\models\SpecialTypeOlimpic */
/* @var $model \olympic\forms\SpecialTypeOlimpicEditForm */
/* @var $form yii\widgets\ActiveForm */

?>
<div>
    <?php $form = ActiveForm::begin([ 'id' => 'form-olympic-spec-type', 'enableAjaxValidation' => true ]); ?>
    <div class="box box-default">
        <div class="box-body">
            <?= $form->field($model, 'special_type_id')->widget(
                Select2::class, [
                'data' => $model->specialTypeOlimpicList(),
                'options' => ['placeholder' => ''],
                'pluginOptions' => ['allowClear' => true,
                    'dropdownParent' => '#modal'
                ],
            ]) ?>
        </div>
    </div>

    <div class="form-group">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>
</div>

