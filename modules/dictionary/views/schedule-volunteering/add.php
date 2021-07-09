<?php
/* @var  $this \yii\web\View  */
/* @var $model \modules\dictionary\forms\ReworkingVolunteeringForm
/* @var $form yii\bootstrap\ActiveForm */

use kartik\date\DatePicker;
use modules\entrant\helpers\DateFormatHelper;
use yii\bootstrap\ActiveForm;
use yii\helpers\Html;
$hours = [];
for ($i = 1; $i <= 8; $i++) {
    $hours[$i] = $i;
}
?>
<div class="mt-20 table-responsive">
    <?php $form = ActiveForm::begin(['id'=> 'form-reworking']); ?>
    <?= $form->field($model, 'text')->textarea() ?>
    <?= $form->field($model, 'count_hours')->dropDownList($hours)?>
    <div class="form-group">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
    </div>
    <?php ActiveForm::end(); ?>
</div>
