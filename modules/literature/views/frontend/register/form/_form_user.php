<?php
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \modules\literature\forms\RegisterForm */

use yii\helpers\Html;
use yii\widgets\ActiveForm; ?>
<?php $form = ActiveForm::begin(['id'=> 'form-reg']); ?>
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
    <div class="col-md-12">
        <div class="form-group">
            <?= Html::submitButton('Далее', ['class' => 'btn btn-lg btn-success pull-right']) ?>
        </div>
    </div>
<?php ActiveForm::end(); ?>


