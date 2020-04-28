<?php

use modules\entrant\helpers\OtherDocumentHelper;
use yii\bootstrap\ActiveForm;
use yii\helpers\Html;
?>
<?php $form = ActiveForm::begin(['id' => 'edu', 'options' => []]); ?>
    <?= Html::dropDownList("other_id", [], OtherDocumentHelper::listPreemptiveRightUser(Yii::$app->user->identity->getId()), ['class'=>'form-control'])?>
    <div class="form-group m-10">
        <center>
             <?= Html::submitButton("Сохранить ответ", ['class' => 'btn btn-success']) ?>
        </center>
    </div>
<?php ActiveForm::end(); ?>
