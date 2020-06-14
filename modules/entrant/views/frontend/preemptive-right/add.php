<?php

use modules\entrant\helpers\OtherDocumentHelper;
use yii\bootstrap\ActiveForm;
use yii\helpers\Html;
?>
<?php $form = ActiveForm::begin(['id' => 'edu', 'options' => []]); ?>
    <?= Html::dropDownList("other_id", [], OtherDocumentHelper::listPreemptiveRightUser($userId), ['class'=>'form-control'])?>
    <div class="form-group m-10">
        <center>
             <?= Html::submitButton("Сохранить", ['class' => 'btn btn-success']) ?>
        </center>
    </div>
<?php ActiveForm::end(); ?>
