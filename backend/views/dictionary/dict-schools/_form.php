<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model dictionary\forms\DictSchoolsForm */
/* @var $form yii\widgets\ActiveForm */
?>
<div>
    <?php $form = ActiveForm::begin(['id' => 'form-school']); ?>
    <div class="box box-default">
        <div class="box-body">
            <?= $form->field($model, 'name')->textInput() ?>

            <?= $form->field($model, 'country_id')->dropDownList($model->countryList(), ["prompt" => "Выберите страну"]) ?>

            <?= $form->field($model, 'region_id')->dropDownList($model->regionList(), ["prompt" => "Выберите регион"]) ?>
        </div>
    </div>

    <div class="form-group">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
