<?php
/* @var $model modules\entrant\forms\AddressForm */
/* @var $form yii\bootstrap\ActiveForm */

use yii\bootstrap\ActiveForm;
use yii\helpers\Html;
use dictionary\helpers\DictCountryHelper;
use modules\entrant\helpers\AddressHelper;
?>
<div class="container">
    <div class="row">
        <div class="col-md-12 mt-30">
            <h1><?= Html::encode($this->title) ?></h1>
            <?php $form = ActiveForm::begin(['id'=> 'form-address']); ?>
            <?= $form->field($model, 'country_id')->dropDownList(DictCountryHelper::countryList(), ['prompt'=> 'Выберите страну']) ?>
            <?= $form->field($model, 'type')->dropDownList(AddressHelper::typeOfAddress()) ?>
            <?= $form->field($model, 'postcode')->textInput(['maxlength' => true]) ?>
            <?= $form->field($model, 'region')->textInput(['maxlength' => true]) ?>
            <?= $form->field($model, 'district')->textInput(['maxlength' => true]) ?>
            <?= $form->field($model, 'city')->textInput(['maxlength' => true]) ?>
            <?= $form->field($model, 'village')->textInput(['maxlength' => true]) ?>
            <?= $form->field($model, 'street')->textInput(['maxlength' => true]) ?>
            <?= $form->field($model, 'house')->textInput(['maxlength' => true]) ?>
            <?= $form->field($model, 'housing')->textInput(['maxlength' => true]) ?>
            <?= $form->field($model, 'building')->textInput(['maxlength' => true]) ?>
            <?= $form->field($model, 'flat')->textInput(['maxlength' => true]) ?>
            <div class="form-group">
                <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
            </div>
            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>