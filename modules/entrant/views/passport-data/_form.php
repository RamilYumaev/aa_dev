<?php
/* @var $model modules\entrant\forms\PassportDataForm */
/* @var $form yii\bootstrap\ActiveForm */

use modules\entrant\helpers\DateFormatHelper;
use yii\bootstrap\ActiveForm;
use yii\helpers\Html;
use dictionary\helpers\DictCountryHelper;
use modules\dictionary\helpers\DictIncomingDocumentTypeHelper;
use yii\widgets\MaskedInput;
use kartik\date\DatePicker;
?>
<div class="container">
    <div class="row">
        <div class="col-md-12 mt-30">
            <h1><?= Html::encode($this->title) ?></h1>
            <?php $form = ActiveForm::begin(['id'=> 'form-passport']); ?>
            <?= $form->field($model, 'nationality')->dropDownList(DictCountryHelper::countryList(), ['prompt'=> 'Выберите страну']) ?>
            <?= $form->field($model, 'type')->dropDownList(DictIncomingDocumentTypeHelper::listType(DictIncomingDocumentTypeHelper::TYPE_PASSPORT)) ?>
            <?= $form->field($model, 'series')->textInput(['maxlength' => true]) ?>
            <?= $form->field($model, 'number')->textInput(['maxlength' => true]) ?>
            <?= $form->field($model, 'date_of_birth')->widget(DatePicker::class, DateFormatHelper::dateSettingWidget()); ?>
            <?= $form->field($model, 'place_of_birth')->textInput(['maxlength' => true]) ?>
            <?= $form->field($model, 'date_of_issue')->widget(DatePicker::class, DateFormatHelper::dateSettingWidget()); ?>
            <?= $form->field($model, 'authority')->textInput(['maxlength' => true]) ?>
            <?= $form->field($model, 'division_code')->widget(MaskedInput::class, [
                'mask' => '999-999',]) ?>
            <?= $form->field($model, 'main_status')->checkbox() ?>
            <div class="form-group">
                <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
            </div>
            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>