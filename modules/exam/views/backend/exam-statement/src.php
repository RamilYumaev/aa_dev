<?php
/* @var $model modules\exam\forms\ExamSrcBBBForm */
/* @var $form yii\bootstrap\ActiveForm */

use modules\exam\helpers\ExamStatementHelper;
use yii\bootstrap\ActiveForm;
use yii\helpers\Html;
if(is_null($model->exam_st->exam->src_bb)) {
$times = ExamStatementHelper::timeList();
if ($model->voz) {
    unset($times['14:00']);
}
} else {
  $times= ExamStatementHelper::timeSpecList();
  $model->src_bbb = $model->exam_st->exam->src_bb;
}
?>
<?php $form = ActiveForm::begin(['id'=> 'form-src', 'enableAjaxValidation' => true]); ?>
    <?= $form->field($model, 'src_bbb')->textInput(['readonly'=> is_null($model->exam_st->exam->src_bb) ? false : true]); ?>
    <?= $form->field($model, 'time')->dropDownList($times); ?>
    <div class="form-group">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
    </div>
<?php ActiveForm::end(); ?>