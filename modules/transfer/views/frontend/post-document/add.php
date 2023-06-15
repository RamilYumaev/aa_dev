<?php
/* @var  $this \yii\web\View  */
/* @var $model modules\transfer\forms\PacketDocumentUserForm
/* @var $form yii\bootstrap\ActiveForm */

use kartik\date\DatePicker;
use modules\entrant\helpers\DateFormatHelper;
use yii\bootstrap\ActiveForm;
use yii\helpers\Html;
?>
<div class="mt-20 table-responsive">
    <?php $form = ActiveForm::begin(['id'=> 'form-transfer']); ?>
    <?= $form->field($model, 'number')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'date')->widget(DatePicker::class, DateFormatHelper::dateSettingWidget())->label($model->isRemove() ? 'Дата приказа об отчислении' : 'Дата выдачи') ?>
    <?= $form->field($model, 'authority')->textInput(['maxlength' => true]) ?>
    <?php if($model->isRemove()): ?>
        <?= $form->field($model, 'cause_id')->dropDownList($model->listCauses(), ['id' => 'cause'])->label('Причина отчисления') ?>
        <?= $form->field($model, 'note')->textInput(['maxlength' => true, 'id' => 'cause_note'])->label('Другая причина отчисления') ?>
    <?php endif; ?>
    <div class="form-group">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
    </div>
    <?php ActiveForm::end(); ?>
</div>
<?php $this->registerJs('
var causeNote = $(".form-group.field-cause_note");
var cause = $("#cause")
cause.on("change init", function() { 
if(this.value == 5){
causeNote.show();
}else {
causeNote.hide();
}
});
cause.trigger("init");
'); ?>