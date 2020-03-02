<?php
/* @var $model olympic\forms\auth\SchooLUserCreateForm */
/* @var $form yii\bootstrap\ActiveForm */
use yii\helpers\Html;
?>
    <?= $form->field($model->schoolUser, 'check_region_and_country_school')->checkbox(); ?>

    <?= $form->field($model->schoolUser, 'country_school')->dropDownList($model->schoolUser->countryList(), ['prompt'=> 'Выберите страну']) ?>

    <?= $form->field($model->schoolUser, 'region_school')->dropDownList($model->schoolUser->regionList(), ['prompt'=> 'Выберите регион']) ?>

    <?= $form->field($model->schoolUser, 'school_id')->widget(\kartik\select2\Select2::class, [
        'data' => '',
        'options' => ['placeholder' => 'Выберите учебную организацию'],
        'pluginOptions' => [
            'allowClear' => true
        ],
    ]); ?>

    <?= $form->field($model->schoolUser, 'check_new_school')->checkbox(); ?>

    <?= $form->field($model->schoolUser, 'check_rename_school')->checkbox(); ?>

    <?= $form->field($model->schoolUser, 'new_school')->textInput(['maxlength' => true]) ?>

    <?= Html::activeHiddenInput($model,  'country_id') ?>

    <?= Html::activeHiddenInput($model,  'region_id') ?>

    <?= Html::activeHiddenInput($model->schoolUser,  'school') ?>

    <?= Html::activeHiddenInput($model->schoolUser,  'region_school_h') ?>

    <?= Html::activeHiddenInput($model->schoolUser,  'country_school_h')?>



