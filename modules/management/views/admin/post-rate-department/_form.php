<?php
/* @var $model modules\management\forms\PostRateDepartmentForm */
/* @var $form yii\bootstrap\ActiveForm */

use kartik\color\ColorInput;
use kartik\select2\Select2;
use modules\management\models\DictDepartment;
use modules\management\models\PostManagement;
use modules\management\models\PostRateDepartment;
use yii\bootstrap\ActiveForm;
use yii\helpers\Html;
?>

<div class="box">
    <div class="box-body">
        <?php $form = ActiveForm::begin(['id'=> 'form-post-rate-department']); ?>
        <?= $form->field($model, 'dict_department_id')->dropDownList(DictDepartment::find()->allColumn(),['prompt' => "Выберите отдел"]) ?>
        <?= $form->field($model, 'post_management_id')->dropDownList(PostManagement::find()->allColumn(),['prompt' => "Выберите должность"]) ?>
        <?= $form->field($model, 'rate')->dropDownList((new PostRateDepartment)->getRateList(),['prompt' => "Выберите ставку"]) ?>
        <?= $form->field($model, 'taskList')->widget(Select2::class, [
            'options' => ['placeholder' => 'Выберите...', 'multiple' => true],
            'pluginOptions' => ['allowClear' => true],
            'data' => \modules\management\models\DictTask::find()->allColumn('description')
        ]) ?>
        <div class="form-group">
            <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
        </div>
        <?php ActiveForm::end(); ?>
    </div>
</div>
