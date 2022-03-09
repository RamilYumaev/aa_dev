<?php

/* @var $form yii\bootstrap\ActiveForm */
/* @var $model common\auth\forms\SignupForm; */

?>
<fieldset>
    <legend>Личные данные участника</legend>
    <div class="col-md-4">
        <?= $form->field($profile, 'last_name')->textInput(['maxlength' => true]) ?>
        <?= $form->field($profile, 'gender')->dropDownList($profile->genderList()) ?>
        <?= $form->field($model, 'password')->passwordInput() ?>
    </div>
    <div class="col-md-4">
        <?= $form->field($profile, 'first_name')->textInput(['maxlength' => true]) ?>
        <?= $form->field($profile, 'phone')->widget(\borales\extensions\phoneInput\PhoneInput::class, [
            'jsOptions' => [
                'preferredCountries' => ['ru'],
                'separateDialCode'=>true
            ]
        ]) ?>
        <?= $form->field($model, 'password_repeat')->passwordInput() ?>
    </div>
    <div class="col-md-4">
        <?= $form->field($profile, 'patronymic')->textInput(['maxlength' => true]) ?>
        <?= $form->field($model, 'email')->textInput() ?>
    </div>
</fieldset>




