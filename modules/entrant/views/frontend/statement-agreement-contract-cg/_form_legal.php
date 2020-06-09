<?php
/* @var $model modules\entrant\forms\LegalEntityForm */
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
            <?php $form = ActiveForm::begin(['id'=> 'form-legal']); ?>
            <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
            <?= $form->field($model, 'fio')->textInput(['maxlength' => true]) ?>
            <?= $form->field($model, 'position')->textInput(['maxlength' => true]) ?>
            <?= $form->field($model, 'footing')->textInput(['maxlength' => true]) ?>
            <?= $form->field($model, 'requisites')->textInput(['maxlength' => true]) ?>
            <?= $form->field($model, 'bank')->textarea() ?>
            <?= $form->field($model, 'ogrn')->textInput(['maxlength' => true]) ?>
            <?= $form->field($model, 'inn')->textInput(['maxlength' => true]) ?>
            <?= $form->field($model, 'phone')->textInput(['maxlength' => true]) ?>
            <?= $form->field($model, 'address')->textInput(['maxlength' => true]) ?>
            <?= $form->field($model, 'postcode')->textInput(['maxlength' => true]) ?>
            <div class="form-group">
                <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
            </div>
            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>