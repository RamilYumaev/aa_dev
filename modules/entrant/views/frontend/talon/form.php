<?php

use modules\entrant\helpers\OtherDocumentHelper;
use yii\bootstrap\ActiveForm;
use yii\helpers\Html;
?>
<?php $form = ActiveForm::begin(['id' => 'talon',  'enableAjaxValidation' => true]); ?>
<?= $form->field($model, 'name')->textInput() ?>
    <div class="form-group m-10">
        <center>
            <?= Html::submitButton("Сохранить", ['class' => 'btn btn-success']) ?>
        </center>
    </div>
<?php ActiveForm::end(); ?>