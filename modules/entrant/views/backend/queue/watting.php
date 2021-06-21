<?php
/* @var $model \modules\entrant\models\Talons */
/* @var $form yii\bootstrap\ActiveForm */

use yii\bootstrap\ActiveForm;
use yii\helpers\Html;
use kartik\file\FileInput;
$all =[];
for ($i=1; $i<=50; $i++) {
    $all[$i] = $i;
}
?>
<?php $form = ActiveForm::begin(['id'=> 'form-message']); ?>
    <?= $form->field($model, 'num_of_table')->dropDownList($all)->label('Номер стола');?>
    <div class="form-group">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
    </div>
<?php ActiveForm::end(); ?>