<?php

/* @var $form yii\bootstrap\ActiveForm */
/* @var $model olympic\forms\auth\SchooLUserForm */

?>
    <?= $form->field($model, 'check_region_and_country_school')->checkbox(); ?>

    <?= $form->field($model, 'country_school')->dropDownList($model->countryList(), ['prompt'=> 'Выберите страну']) ?>

    <?= $form->field($model, 'region_school')->dropDownList($model->regionList(), ['prompt'=> 'Выберите регион']) ?>

    <?= $form->field($model, 'school_id')->widget(\kartik\select2\Select2::class, [
        'data' => '',
        'options' => ['placeholder' => 'Выберите учебную организацию'],
        'pluginOptions' => [
            'allowClear' => true
        ],
    ]);  ?>

    <?= $form->field($model, 'check_new_school')->checkbox(); ?>

    <?= $form->field($model, 'check_rename_school')->checkbox(); ?>

    <?= $form->field($model, 'new_school')->textInput(['maxlength' => true]) ?>




