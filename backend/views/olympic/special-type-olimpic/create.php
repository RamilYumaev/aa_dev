<?php

use kartik\select2\Select2;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $model \olympic\forms\SpecialTypeOlimpicCreateForm */
/* @var $form yii\widgets\ActiveForm */
?>
<div>
    <?php $form = ActiveForm::begin(['id' => 'form-olympic-spec-type','enableAjaxValidation' => true]); ?>
    <div class="box box-default">
        <div class="box-body">
            <?= $form->field($model, 'special_type_id')->widget(
                Select2::class, [
                'data' => $model->specialTypeOlimpicList(),
                'options' => ['placeholder' => ''],
                'pluginOptions' => ['allowClear' => true,
                    'dropdownParent' => '#modal'
                ],
            ]); ?>
        </div>
    </div>

    <div class="form-group">
        <?= Html::a('Сохранить',$form->action,['class'=>'btn btn-primary','data-method'=>'POST']); ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
