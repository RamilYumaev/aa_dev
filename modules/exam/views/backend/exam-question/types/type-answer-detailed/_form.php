<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use mihaildev\ckeditor\CKEditor;
use mihaildev\elfinder\ElFinder;

/* @var $this yii\web\View */
/* @var $model testing\forms\question\TestQuestionForm*/
?>
<div class="row">
<?php $form = ActiveForm::begin(['id' => 'form-question-answer-detailed']); ?>
    <div class="col-md-12">
        <?= $this->render('@modules/exam/views/backend/exam-question/_form-question.php', ['model' => $model, 'form' => $form,  'id' => '']) ?>
    </div>
<?php ActiveForm::end(); ?>
</div>
