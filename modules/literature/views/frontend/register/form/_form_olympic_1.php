<?php

/* @var $form yii\bootstrap\ActiveForm */
/* @var $model modules\literature\models\LiteratureOlympic */

use kartik\date\DatePicker;
use kartik\file\FileInput;
use modules\entrant\helpers\DateFormatHelper;
use yii\bootstrap\ActiveForm;
use yii\helpers\Html; ?>
<?php $form = ActiveForm::begin(['id'=> 'form-reg']); ?>
    <div class="col-md-4">
        <?= $form->field($model, 'type')->dropDownList($model->getDocuments()) ?>
        <?= $form->field($model, 'birthday')->widget(DatePicker::class, DateFormatHelper::dateSettingWidget()); ?>
        <?= $form->field($model, 'series')->textInput(['maxlength' => true]) ?>
        <?= $form->field($model, 'number')->textInput(['maxlength' => true]) ?>
        <?= $form->field($model, 'date_issue')->widget(DatePicker::class, DateFormatHelper::dateSettingWidget()); ?>
        <?= $form->field($model, 'authority')->textInput(['maxlength' => true]) ?>
    </div>
    <div class="col-md-4">
        <?= $form->field($model, 'region')->dropDownList(\dictionary\helpers\DictRegionHelper::regionList()) ?>
        <?= $form->field($model, 'zone')->textInput(['maxlength' => true]) ?>
        <?= $form->field($model, 'city')->textInput(['maxlength' => true]) ?>
    </div>
    <div class="col-md-4">
        <?= $form->field($model, 'photo')->widget(FileInput::class, ['language'=> 'ru',
            'options' => ['accept' => 'image/*'],
        ]);?>
    </div>
    <div class="col-md-12">
        <?= $form->field($model, 'agree_file')->widget(FileInput::class, ['language'=> 'ru',
            'options' => [],
        ]);?>
    </div>
    <div class="col-md-12">
        <div class="form-group">
            <?= Html::submitButton('Далее', ['class' => 'btn btn-success pull-right']) ?>
        </div>
    </div>
<?php ActiveForm::end(); ?>







