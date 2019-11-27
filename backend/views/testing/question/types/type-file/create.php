<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use mihaildev\ckeditor\CKEditor;
use mihaildev\elfinder\ElFinder;

/* @var $this yii\web\View */
/* @var $model testing\forms\question\TestQuestionTypesFileForm*/

?>
<div class="row">
<?php $form = ActiveForm::begin(['id' => 'form-question-file']); ?>
    <div class="col-md-12">
        <div class="box">
            <div class="box-body">
                <?= $form->field($model, 'file_type_id')->dropDownList($model->groupFileTypesList())?>
            </div>
        </div>
        <?= $this->render('@backend/views/testing/question/_form-question', ['model' => $model->question, 'form' => $form,  'id' => '']) ?>
    </div>
<?php ActiveForm::end(); ?>
</div>
