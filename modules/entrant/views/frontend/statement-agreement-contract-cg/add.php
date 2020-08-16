<?php

use modules\entrant\helpers\ContractHelper;
use yii\bootstrap\ActiveForm;
use yii\helpers\Html;
/* @var  $agreement \modules\entrant\models\StatementAgreementContractCg */
$array = [1=>'Сам обучающийся', 2 => 'Законный представитель обучающегося', 3 =>'Юридическое лицо'];
if(!\Yii::$app->user->identity->eighteenYearsOld()) {
    unset($array[1]);
}
$legal = ContractHelper::legal($agreement->statementCg->statement->user_id);
$personal = ContractHelper::personal($agreement->statementCg->statement->user_id);
?>
<?php $form = ActiveForm::begin(['id' => 'edu', 'options' => []]); ?>
    <?= Html::dropDownList("customer", $agreement->type, $array , ['class'=>'form-control', 'id' => 'type'])?> <br/>
    <div id="legal">
    <?= Html::dropDownList("id-legal", $agreement->record_id, [ 0 => 'новое']+$legal , ['class'=>'form-control', 'id' => 'legal-p'])?>
    </div>
    <div id="personal">
    <?= Html::dropDownList("id-personal", $agreement->record_id, [0 => 'новое'] + $personal , ['class'=>'form-control', 'id' => 'personal-p'])?>
    </div>
    <div class="form-group m-10">
        <center>
             <?= Html::submitButton("Выбрать", ['class' => 'btn btn-success']) ?>
        </center>
    </div>
<?php ActiveForm::end(); ?>
<?php
$this->registerJs(<<<JS
"use strict";
var type = $("#type");
var legal = $("#legal");
var personal = $('#personal');

type.on("change init", function() {
    if (this.value == 2) {
        personal.show();
        legal.hide();
    } else if (this.value == 3) {
        personal.hide();
        legal.show();
    } else {
        personal.hide();
        legal.hide();
    }
    
});
type.trigger("init");
JS
);



