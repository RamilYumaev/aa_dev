<?php

use kartik\date\DatePicker;
use modules\entrant\helpers\DateFormatHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model modules\literature\models\LiteratureOlympic */
/* @var $form yii\widgets\ActiveForm */
?>
<div class="literature-olympic-form">
    <div class="box-primary">
        <div class="box-header">Личные данные</div>
        <div class="box-body">
            <div class="col-md-4">
                <?= $form->field($model->profile, 'last_name')->textInput(['maxlength' => true]) ?>
                <?= $form->field($model->profile, 'patronymic')->textInput(['maxlength' => true]) ?>
                <?= $form->field($model->profile, 'gender')->dropDownList($model->profile->genderList()) ?>
            </div>
            <div class="col-md-4">
                <?= $form->field($model->profile, 'first_name')->textInput(['maxlength' => true]) ?>
                <?= $form->field($model->profile, 'phone')->widget(\borales\extensions\phoneInput\PhoneInput::class, [
                    'jsOptions' => [
                        'preferredCountries' => ['ru'],
                        'separateDialCode'=>true
                    ]
                ]) ?>
                <?= $form->field($model->profile, 'region_id')->dropDownList($model->profile->regionList()) ?>
            </div>
            <div class="col-md-4">
                <?= $form->field($model->user, 'username')->textInput() ?>
                <?= $form->field($model->user, 'email')->textInput() ?>
                <?php if(!$model->ifUser): ?>
                    <?= $form->field($model->user, 'password')->passwordInput() ?>
                    <?= $form->field($model->user, 'password_repeat')->passwordInput() ?>
                <?php endif; ?>
            </div>
            <?= $form->field($model, 'ids')->hiddenInput()->label('') ?>
        </div>
    </div>
</div>
