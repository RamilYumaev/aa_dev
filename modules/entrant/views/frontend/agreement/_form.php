<?php
/* @var $model modules\entrant\forms\AgreementForm */
/* @var $form yii\bootstrap\ActiveForm */

use kartik\date\DatePicker;
use kartik\select2\Select2;
use modules\dictionary\helpers\DictOrganizationsHelper;
use modules\entrant\helpers\DateFormatHelper;
use yii\bootstrap\ActiveForm;
use yii\helpers\Html;

\modules\entrant\assets\agreement\AgreementAsset::register($this);
?>
<div class="container">
    <div class="row">
        <div class="col-md-12 mt-30">
            <h1><?= Html::encode($this->title) ?></h1>
            <?php $form = ActiveForm::begin(['id'=> 'form-agreement']); ?>
            <?= $form->field($model, 'organization_id')->widget(Select2::class, [
                'data' => DictOrganizationsHelper::organizationList(),
                'options' => ['placeholder' => 'Выберите организацию'],
                'pluginOptions' => [
                    'allowClear' => true
                ],
            ]); ?>
            <?= $form->field($model, 'check_new')->checkbox(); ?>
            <?= $form->field($model, 'check_rename')->checkbox(); ?>
            <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
            <?= $form->field($model, 'number')->textInput(['maxlength' => true]) ?>
            <?= $form->field($model, 'date')->widget(DatePicker::class, DateFormatHelper::dateSettingWidget()); ?>
            <div class="form-group">
                <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
            </div>
            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>