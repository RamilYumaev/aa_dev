<?php
/* @var $model modules\entrant\forms\AgreementForm */
/* @var $agreement modules\entrant\models\Agreement */
/* @var $form yii\bootstrap\ActiveForm */

use kartik\date\DatePicker;
use kartik\select2\Select2;
use modules\dictionary\helpers\DictOrganizationsHelper;
use modules\entrant\helpers\DateFormatHelper;
use yii\bootstrap\ActiveForm;
use yii\helpers\Html;
?>
<div class="container">
    <div class="row">
        <div class="col-md-12 mt-30">
            <h1><?= Html::encode($this->title) ?></h1>
            <p><?= $agreement ? "Наниматель: ".($agreement->organization ? $agreement->fullOrganization : 'нет данных') :"" ?></p>
            <p><?= $agreement ? "Работодатель: ".($agreement->organizationWork ? $agreement->fullOrganizationWork : 'нет данных') :"" ?></p>
            <?php $form = ActiveForm::begin(['id'=> 'form-agreement']); ?>
            <?= $form->field($model, 'number')->textInput(['maxlength' => true]) ?>
            <?= $form->field($model, 'date')->widget(DatePicker::class, DateFormatHelper::dateSettingWidget()); ?>
            <div class="form-group">
                <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
            </div>
            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>