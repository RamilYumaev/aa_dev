<?php
/* @var $model modules\dictionary\forms\JobEntrantForm */
/* @var $form yii\bootstrap\ActiveForm */

use kartik\select2\Select2;
use yii\bootstrap\ActiveForm;
use yii\helpers\Html;
\common\auth\actions\assets\EntrantAsset::register($this);
?>

<div class="box">
    <div class="box-body">
        <?php $form = ActiveForm::begin(['id'=> 'form-job-entrant']); ?>
        <?= $form->field($model, 'user_id')->widget(Select2::class, [
                'data'=>\olympic\helpers\auth\ProfileHelper::getVolunteering(),
                'options'=> ['placeholder'=>'Выберите пользователя'],
                'pluginOptions' => ['allowClear' => true],
        ]) ?>
        <?= $form->field($model, 'category_id')->dropDownList(\modules\dictionary\helpers\JobEntrantHelper::listCategories()) ?>
        <?= $form->field($model, 'faculty_id')->dropDownList(\dictionary\helpers\DictFacultyHelper::facultyList()) ?>
        <?= $form->field($model, 'examiner_id')->dropDownList(\modules\dictionary\helpers\DisciplineExaminerHelper::listExaminer()) ?>
        <?= $form->field($model, 'email_id')->widget(
            Select2::class, [
            'data'=>\common\auth\helpers\SettingEmailHelper::all(),
            'options'=> ['placeholder'=>'Выберите пользователя'],
            'pluginOptions' => ['allowClear' => true]]) ?>
        <?= $form->field($model, 'right_full')->checkbox()?>
        <div class="form-group">
            <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
        </div>
        <?php ActiveForm::end(); ?>
    </div>
</div>
