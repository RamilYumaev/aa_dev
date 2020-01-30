<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model \dictionary\forms\OlimpiadsTypeTemplatesCreateForm */
/* @var $form yii\widgets\ActiveForm */

?>
<div>
    <?php $form = ActiveForm::begin(['id' => 'form-olympiads-type-templates', 'enableAjaxValidation' => true]); ?>

    <?= $form->field($model, 'year')->dropDownList($model->years()) ?>

    <?= $form->field($model, 'number_of_tours')->dropDownList($model->numberOfTours()) ?>

    <?= $form->field($model, 'form_of_passage')->dropDownList($model->formOfPassage()) ?>

    <?= $form->field($model, 'edu_level_olimp')->dropDownList($model->levelOlimp()) ?>

    <?= $form->field($model, 'special_type')->dropDownList($model->specialTypeOlimpicList(),
        ['prompt' => "Выберите специальный тип"]); ?>

    <?= $form->field($model, 'template_id')->dropDownList($model->templatesList()) ?>

    <?= $form->field($model, 'range')->dropDownList($model->range()) ?>


    <div class="form-group">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>
</div>
