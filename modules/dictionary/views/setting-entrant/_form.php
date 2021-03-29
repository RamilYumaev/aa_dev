<?php
/* @var $model modules\dictionary\forms\SettingEntrantForm */
/* @var $form yii\bootstrap\ActiveForm */

use yii\bootstrap\ActiveForm;
use yii\helpers\Html;
?>

<div class="box">
    <div class="box-body">
        <?php $form = ActiveForm::begin(['id'=> 'form-job-entrant']); ?>
        <?= $form->field($model, 'datetime_start')->widget(\kartik\datetime\DateTimePicker::class); ?>
        <?= $form->field($model, 'datetime_end')->widget(\kartik\datetime\DateTimePicker::class); ?>
        <?= $form->field($model, 'faculty_id')->dropDownList(\dictionary\helpers\DictFacultyHelper::facultyListSetting())?>
        <?= $form->field($model, 'edu_level')->dropDownList(\dictionary\helpers\DictCompetitiveGroupHelper::getEduLevelsAbbreviated())?>
        <?= $form->field($model, 'form_edu')->dropDownList(\dictionary\helpers\DictCompetitiveGroupHelper::getEduForms()) ?>
        <?= $form->field($model, 'finance_edu')->dropDownList(\dictionary\helpers\DictCompetitiveGroupHelper::listFinances())?>
        <?= $form->field($model, 'special_right')->dropDownList(\dictionary\helpers\DictCompetitiveGroupHelper::getSpecialRight())?>
        <?= $form->field($model, 'type')->dropDownList((new \modules\dictionary\models\SettingEntrant())->getTypeList()) ?>
        <?= $form->field($model, 'note')->textarea() ?>
        <?= $form->field($model, 'is_vi')->checkbox() ?>
        <div class="form-group">
            <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
        </div>
        <?php ActiveForm::end(); ?>
    </div>
</div>
