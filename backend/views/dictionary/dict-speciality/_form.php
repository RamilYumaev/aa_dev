<?php

use kartik\date\DatePicker;
use kartik\datetime\DateTimePicker;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model dictionary\forms\DictSpecialityCreateForm | dictionary\forms\DictSpecialityEditForm*/
/* @var $form yii\widgets\ActiveForm */

?>
    <?php $form = ActiveForm::begin(['id' => 'form-speciality']); ?>
    <div class="box box-default">
        <div class="box-body">
            <?= $form->field($model, 'code')->textInput(['maxlength' => true]) ?>
            <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
            <?= $form->field($model, 'short')->textInput(['maxlength' => true]) ?>
            <?= $form->field($model, 'edu_level')->dropDownList(\dictionary\helpers\DictCompetitiveGroupHelper::getEduLevelsAbbreviated()) ?>
            <?= $form->field($model, 'series')->textInput(['maxlength' => true]) ?>
            <?= $form->field($model, 'number')->textInput(['maxlength' => true]) ?>
            <?= $form->field($model, 'date_begin')->widget(DatePicker::classname(), [
                'options' => ['placeholder' => 'Введите дату'],
                'pluginOptions' => [
                    'autoclose' => true,
                    'format' => 'yyyy-mm-dd'
                ]
            ]);
            ?>
            <?= $form->field($model, 'date_end')->widget(DatePicker::classname(), [
                'options' => ['placeholder' => 'Введите дату'],
                'pluginOptions' => [
                    'autoclose' => true,
                    'format' => 'yyyy-mm-dd'
                ]
            ]);
            ?>
        </div>
    </div>

    <div class="form-group">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>
