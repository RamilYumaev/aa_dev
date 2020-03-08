<?php

/* @var $model modules\entrant\forms\DocumentEducationForm */
/* @var $form yii\bootstrap\ActiveForm */

use yii\bootstrap\ActiveForm;
use yii\helpers\Html;
use modules\entrant\helpers\DateFormatHelper;
use modules\entrant\helpers\dictionary\DictIncomingDocumentTypeHelper;
use common\auth\helpers\UserSchoolHelper;
use kartik\date\DatePicker;
?>
<div class="container">
    <div class="row">
        <div class="col-md-12 mt-30">
            <h1><?= Html::encode($this->title) ?></h1>
            <?php $form = ActiveForm::begin(['id'=> 'form-school-user']); ?>
            <?= $form->field($model, 'school_id')->dropDownList(UserSchoolHelper::userSchoolAll(Yii::$app->user->identity->getId())) ?>
            <?= $form->field($model, 'type')->dropDownList(DictIncomingDocumentTypeHelper::listType(DictIncomingDocumentTypeHelper::TYPE_EDUCATION)) ?>
            <?= $form->field($model, 'series')->textInput(['maxlength' => true]) ?>
            <?= $form->field($model, 'number')->textInput(['maxlength' => true]) ?>
            <?= $form->field($model, 'date')->widget(DatePicker::class, DateFormatHelper::dateSettingWidget()); ?>
            <?= $form->field($model, 'year')->textInput(['maxlength' => true]) ?>
            <div class="form-group">
                <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
            </div>
            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>