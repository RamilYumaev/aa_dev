<?php
/* @var $model modules\dictionary\forms\AdminCenterForm */
/* @var $form yii\bootstrap\ActiveForm */

use kartik\select2\Select2;
use modules\dictionary\models\JobEntrant;
use yii\bootstrap\ActiveForm;
use yii\helpers\Html;
?>
<div class="box">
    <div class="box-body">
        <?php $form = ActiveForm::begin(['id'=> 'admin']); ?>
        <?= $form->field($model, 'job_entrant_id')->widget(Select2::class, [
            'data'=> (new JobEntrant())->allColumn(),
            'options'=> ['placeholder'=>'Выберите пользователя'],
            'pluginOptions' => ['allowClear' => true],
        ]) ?>
        <?= $form->field($model, 'category')->dropDownList(\modules\dictionary\helpers\JobEntrantHelper::listVolunteeringCategories()) ?>
        <div class="form-group">
            <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
        </div>
        <?php ActiveForm::end(); ?>
    </div>
</div>
