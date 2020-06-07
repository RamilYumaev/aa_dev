<?php
/* @var $model modules\entrant\forms\PersonalEntityForm */
/* @var $form yii\bootstrap\ActiveForm */

use modules\entrant\helpers\DateFormatHelper;
use yii\bootstrap\ActiveForm;
use yii\helpers\Html;
use modules\dictionary\helpers\DictIncomingDocumentTypeHelper;
use yii\widgets\MaskedInput;
use kartik\date\DatePicker;
?>
<div class="container">
    <div class="row">
        <div class="col-md-12 mt-30">
            <h1><?= Html::encode($this->title) ?></h1>
            <?php $form = ActiveForm::begin(['id'=> 'form-personal']); ?>
            <?= $form->field($model, 'fio')->textInput(['maxlength' => true]) ?>
            <?= $form->field($model, 'phone')->textInput(['maxlength' => true]) ?>
            <?= $form->field($model, 'address')->textInput(['maxlength' => true]) ?>
            <?= $form->field($model, 'postcode')->textInput(['maxlength' => true]) ?>
            <?= $form->field($model, 'series')->textInput(['maxlength' => true]) ?>
            <?= $form->field($model, 'number')->textInput(['maxlength' => true]) ?>
            <?= $form->field($model, 'date_of_issue')->widget(DatePicker::class, DateFormatHelper::dateSettingWidget()); ?>
            <?= $form->field($model, 'authority')->textInput(['maxlength' => true]) ?>
            <div class="form-group">
                <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
            </div>
            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>