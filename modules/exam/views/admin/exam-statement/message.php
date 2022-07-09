<?php
/* @var $model modules\exam\forms\ExamStatementMessageForm */
/* @var $form yii\bootstrap\ActiveForm */

use yii\bootstrap\ActiveForm;
use yii\helpers\Html;
use kartik\file\FileInput;
?>
<?php $form = ActiveForm::begin(['id'=> 'form-message']); ?>
    <?= $form->field($model, 'message')->textarea();?>
    <div class="form-group">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
    </div>
<?php ActiveForm::end(); ?>