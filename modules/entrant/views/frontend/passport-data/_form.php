<?php
/* @var $model modules\entrant\forms\PassportDataForm */
/* @var $form yii\bootstrap\ActiveForm */

use modules\entrant\helpers\DateFormatHelper;
use yii\bootstrap\ActiveForm;
use yii\helpers\Html;
use modules\dictionary\helpers\DictIncomingDocumentTypeHelper;
use yii\widgets\MaskedInput;
use kartik\date\DatePicker;

\modules\entrant\assets\passport\PassportAsset::register($this)
?>
<div class="container">
    <div class="row">
        <div class="col-md-12 mt-30">
            <p class="label label-warning fs-15">Заполнять нужно строго как в документе</p>
            <h1><?= Html::encode($this->title) ?></h1>
            <?php $form = ActiveForm::begin(['id'=> 'form-passport']); ?>
            <?= $form->field($model, 'type')->dropDownList(DictIncomingDocumentTypeHelper::listPassport($model->nationality)) ?>
            <?= $form->field($model, 'series')->textInput(['maxlength' => true]) ?>
            <?= $form->field($model, 'number')->textInput(['maxlength' => true]) ?>
            <?= $form->field($model, 'date_of_birth')->widget(DatePicker::class, DateFormatHelper::dateSettingWidget()); ?>
            <?= $form->field($model, 'place_of_birth')->textInput(['maxlength' => true]) ?>
            <?= $form->field($model, 'date_of_issue')->widget(DatePicker::class, DateFormatHelper::dateSettingWidget()); ?>
            <?= $form->field($model, 'authority')->textInput(['maxlength' => true]) ?>
            <?= $form->field($model, 'division_code')->widget(MaskedInput::class, ['mask' => '999-999',]) ?>
            <div class="form-group">
                <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
            </div>
            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>