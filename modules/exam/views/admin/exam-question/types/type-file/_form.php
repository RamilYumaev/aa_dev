<?php

use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model testing\forms\question\TestQuestionTypesForm */


?>
<div class="row">
    <?php $form = ActiveForm::begin(['id' => 'form-question-file']); ?>
    <div class="col-md-12">
        <?= $this->render('@modules/exam/views/backend/exam-question/_form-question.php', ['model' => $model, 'form' => $form,  'id' => '']) ?>
    </div>
    <?php ActiveForm::end(); ?>
</div>
