<?php

use yii\bootstrap\ActiveForm;
use yii\helpers\Html;
/* @var  $type integer|null */
$array = [1=>'Обучающийся', 2 => 'Физическое лицо/Законный представитель', 3 =>'Юридиеческое лицо'];
if(!\Yii::$app->user->identity->eighteenYearsOld()) {
    unset($array[1]);
}
?>
<?php $form = ActiveForm::begin(['id' => 'edu', 'options' => []]); ?>
    <?= Html::dropDownList("customer", $type, $array , ['class'=>'form-control'])?>
    <div class="form-group m-10">
        <center>
             <?= Html::submitButton("Выбрать", ['class' => 'btn btn-success']) ?>
        </center>
    </div>
<?php ActiveForm::end(); ?>
