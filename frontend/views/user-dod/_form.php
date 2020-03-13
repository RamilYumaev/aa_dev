<?php

/* @var $this yii\web\View */
/* @var $dod dod\models\DateDod */
/* @var $model dod\forms\SignUpDodRemoteUserForm*/
/* @var $form yii\bootstrap\ActiveForm */

use yii\bootstrap\ActiveForm;
use yii\helpers\Html;
use modules\dictionary\helpers\DictPostEducationHelper;
?>
<?php $form = ActiveForm::begin(['id'=> 'form-reg-dod']); ?>
      <?= $this->render('@common/user/views/schools/_form', ['model' => $model->schoolUser, 'form' => $form]) ?>
        <?= $form->field($model->statusDodUser, 'status_edu')->dropDownList(DictPostEducationHelper::listNames())?>
        <?= $form->field($model->statusDodUser, 'count')->textInput()?>
        <?= $form->field($model, 'dateDodId')->hiddenInput()->label('') ?>
    <div class="form-group">
        <?= Html::submitButton('Записаться', ['class' => 'btn btn-success']) ?>
    </div>
<?php ActiveForm::end(); ?>
