<?php
/* @var $model modules\entrant\forms\OtherDocumentForm */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $dynamic \modules\superservice\forms\DocumentsDynamicForm | boolean  */

use kartik\date\DatePicker;
use modules\dictionary\helpers\DictDefaultHelper;
use modules\dictionary\helpers\DictIncomingDocumentTypeHelper;
use modules\entrant\helpers\DateFormatHelper;
use yii\bootstrap\ActiveForm;
use yii\helpers\Html;
\modules\entrant\assets\other\OtherDocumentAsset::register($this);

?>
 <?php $form = ActiveForm::begin(['id'=> 'form-other-documents', 'enableAjaxValidation' => $model->isAjax]); ?>
        <div id="other-document-full">
            <?= $form->field($model, 'series')->textInput(['maxlength' => true]) ?>
            <?= $form->field($model, 'number')->textInput(['maxlength' => true]) ?>
            <?= $form->field($model, 'date')->widget(DatePicker::class, DateFormatHelper::dateSettingWidget()); ?>
            <?= $form->field($model, 'authority')->textInput(['maxlength' => true]) ?>
            <?php if($model->type != DictIncomingDocumentTypeHelper::ID_NAME_REFERENCE && ($model->isExemption || $model->exemption_id)): ?>
                <?= $form->field($model, 'exemption_id')->dropDownList(DictDefaultHelper::categoryExemptionList()) ?>
            <?php endif; ?>
        </div>
        <?php if(!in_array($model->type, [DictIncomingDocumentTypeHelper::ID_NAME_REFERENCE, DictIncomingDocumentTypeHelper::ID_PATRIOT_DOC])): ?>
        <?= $form->field($model, 'amount')->textInput() ?>
        <?php endif; ?>
        <?php if(!in_array($model->type, [DictIncomingDocumentTypeHelper::ID_NAME_REFERENCE, DictIncomingDocumentTypeHelper::ID_PATRIOT_DOC])): ?>
            <?= $form->field($model, 'type')->dropDownList($model->listTypesDocument()) ?>
        <?php endif; ?>
        <?php if(in_array($model->type, [DictIncomingDocumentTypeHelper::ID_NAME_REFERENCE])): ?>
            <?= $form->field($model, 'reception_quota')->dropDownList((new \modules\entrant\models\OtherDocument())->getReceptionList()) ?>
        <?php endif; ?>
        <?php if($model->getDocumentsDynamicForm()->getFields()): ?>
            <?= \modules\superservice\widgets\FormVersionDocumentsWidgets::widget(['dynamicModel' => $model->getDocumentsDynamicForm(), 'form'=> $form, 'oldData' => $model->other_data ]) ?>
        <?php endif; ?>
        <div class="form-group">
            <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
        </div>
<?php ActiveForm::end(); ?>