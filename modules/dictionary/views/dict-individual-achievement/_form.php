<?php
/* @var $model modules\dictionary\forms\DictIndividualAchievementForm */
/* @var $form yii\bootstrap\ActiveForm */

use yii\bootstrap\ActiveForm;
use yii\helpers\Html;
use common\helpers\EduYearHelper;
use modules\dictionary\helpers\DictDefaultHelper;
?>

<div class="box">
    <div class="box-body">
        <?php $form = ActiveForm::begin(['id'=> 'form-dict-individual-achievement']); ?>
        <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
        <?= $form->field($model, 'name_short')->textInput(['maxlength' => true]) ?>
        <?= $form->field($model, 'category_id')->dropDownList(DictDefaultHelper::categoryDictIAList()) ?>
        <?= $form->field($model, 'mark')->textInput(['maxlength' => true]) ?>
        <?= $form->field($model, 'year')->dropDownList(EduYearHelper::eduYearList()) ?>
        <div class="form-group">
            <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
        </div>
        <?php ActiveForm::end(); ?>
    </div>
</div>
