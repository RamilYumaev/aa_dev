<?php

/* @var $form yii\bootstrap\ActiveForm */
/* @var $model modules\literature\models\LiteratureOlympic */

use kartik\date\DatePicker;
use kartik\file\FileInput;
use olympic\helpers\auth\ProfileHelper;
use modules\entrant\helpers\DateFormatHelper;
use yii\bootstrap\ActiveForm;
use yii\helpers\Html; ?>
<?php $form = ActiveForm::begin(['id'=> 'form-reg']); ?>
    <div class="col-md-5">
        <?= $form->field($model, 'fio')->textInput(['maxlength' => true]) ?>
        <?= $form->field($model, 'birthday')->widget(DatePicker::class, DateFormatHelper::dateSettingWidget()); ?>
        <?= $form->field($model, 'sex')->dropDownList(ProfileHelper::typeOfGender()) ?>
        <?= $form->field($model, 'place_birth')->textInput(['maxlength' => true]) ?>
    </div>
<div class="col-md-1"></div>
    <div class="col-md-5">
        <?= $form->field($model, 'email') ?>
        <?= $form->field($model, 'phone')->widget(\borales\extensions\phoneInput\PhoneInput::class, [
            'jsOptions' => [
                'preferredCountries' => ['ru'],
                'separateDialCode'=>true
            ]
        ]) ?>
        <?= $form->field($model, 'place_work')->textInput(['maxlength' => true]) ?>
        <?= $form->field($model, 'post')->textInput(['maxlength' => true]) ?>
    </div>
    <div class="col-md-12">
        <?= $form->field($model, 'agree_file')->widget(FileInput::class, ['language'=> 'ru',
        'options' => ['accept' => 'image/*'],
    ]);?>
    </div>
    <div class="col-md-12">
        <div class="form-group">
            <?= Html::submitButton('Добавить', ['class' => 'btn btn-lg btn-success pull-right']) ?>
        </div>
    </div>
<?php ActiveForm::end(); ?>









