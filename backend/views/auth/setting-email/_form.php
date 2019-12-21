<?php


/* @var $this yii\web\View */
/* @var $model common\auth\forms\SettingEmailForm */

use yii\helpers\Html;
use kartik\select2\Select2;

?>
<?= $form->field($model, 'user_id')->widget(Select2::class, [
    'data'=>\olympic\helpers\auth\ProfileHelper::getAllUserFullNameWithEmail(),
    'options'=> ['placeholder'=>'Выберите пользователя'],
])?>
<?= $form->field($model, 'host')->textInput(['maxLength' => true]) ?>
<?= $form->field($model, 'username')->textInput(['maxLength' => true]) ?>
<?= $form->field($model, 'password')->passwordInput(['maxLength' => true]) ?>
<?= $form->field($model, 'port')->textInput(['maxLength' => true]) ?>
<?= $form->field($model, 'encryption')->dropDownList($model->encryptionList()) ?>
<div class="form-group">
    <?= Html::submitButton('Сохранить', ['class' => 'btn btn-primary']) ?>
</div>


