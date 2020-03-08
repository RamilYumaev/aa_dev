<?php
/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model olympic\forms\auth\ProfileCreateForm */

use yii\widgets\MaskedInput;

\common\auth\actions\assets\ProfileAsset::register($this);
?>
<?= $form->field($model, 'last_name')->textInput(['maxlength' => true]) ?>

<?= $form->field($model, 'first_name')->textInput(['maxlength' => true]) ?>

<?= $form->field($model, 'patronymic')->textInput(['maxlength' => true]) ?>

<?= $form->field($model, 'gender')->dropDownList($model->genderList()) ?>

<?= $form->field($model, 'phone')->widget(\borales\extensions\phoneInput\PhoneInput::class, [
    'jsOptions' => [
        'preferredCountries' => ['ru'],
        'separateDialCode'=>true
    ]
]) ?>

<?= $form->field($model, 'country_id')->dropDownList($model->countryList()) ?>

<?= $form->field($model, 'region_id')->dropDownList($model->regionList()) ?>