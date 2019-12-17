<?php


/* @var $this yii\web\View */

/* @var $model \common\auth\forms\SettingEmailForm */

use yii\bootstrap\ActiveForm;
use yii\helpers\Html;

$this->title = 'Настройки эектронной почты для рассылок';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-create">
    <div class="box">
        <div class="box-body">
            <?php $form = ActiveForm::begin(); ?>
            <?= $form->field($model, 'host')->textInput(['maxLength' => true]) ?>
            <?= $form->field($model, 'username')->textInput(['maxLength' => true]) ?>
            <?= $form->field($model, 'password')->passwordInput(['maxLength' => true]) ?>
            <?= $form->field($model, 'port')->textInput(['maxLength' => true]) ?>
            <?= $form->field($model, 'encryption')->dropDownList($model->encryptionList()) ?>
            <div class="form-group">
                <?= Html::submitButton('Сохранить', ['class' => 'btn btn-primary']) ?>
            </div>
            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>
