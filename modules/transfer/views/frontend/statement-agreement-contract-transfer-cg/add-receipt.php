<?php

use yii\bootstrap\ActiveForm;
use yii\helpers\Html;
/* @var  $type integer|null */
/* @var $agreement \modules\entrant\models\StatementAgreementContractCg */
$cost = $agreement->statementCg->cg->education_year_cost;
$discount = $agreement->statementCg->cg->discount;
$totalCost = $cost - ($cost * ($discount/100));
$array = \modules\entrant\helpers\ReceiptHelper::listPeriod($totalCost);
if (!$agreement->is_month) {
    unset($array[1]);
} ?>
<?php $form = ActiveForm::begin(['id' => 'receipt', 'options' => []]); ?>
    <?= Html::dropDownList("period", '',$array , ['class'=>'form-control'])?>
    <div class="form-group m-10">
        <center>
             <?= Html::submitButton("Выбрать", ['class' => 'btn btn-success']) ?>
        </center>
    </div>
<?php ActiveForm::end(); ?>
