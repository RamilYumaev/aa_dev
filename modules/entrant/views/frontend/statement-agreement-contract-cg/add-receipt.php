<?php

use yii\bootstrap\ActiveForm;
use yii\helpers\Html;
/* @var  $type integer|null */
/* @var $cost float */
$cost = 352555.00;
?>
<?php $form = ActiveForm::begin(['id' => 'receipt', 'options' => []]); ?>
    <?= Html::dropDownList("period", 1, \modules\entrant\helpers\ReceiptHelper::listPeriod($cost) , ['class'=>'form-control'])?>
    <div class="form-group m-10">
        <center>
             <?= Html::submitButton("Выбрать", ['class' => 'btn btn-success']) ?>
        </center>
    </div>
<?php ActiveForm::end(); ?>
