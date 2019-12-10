<?php
use yii\helpers\Html;
use testing\helpers\TestQuestionHelper;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $pages integer */
/* @var $models yii\data\ActiveDataProvider */
/* @var $quent testing\models\TestAndQuestions */
/* @var $test \testing\models\Test */

?>
    <div class="row">
    <div class="col-md-12"><?= $this->render('_time')?></div>
    <div class="row">
    <div class="col-md-12">
    <center>
<?php foreach ($models as $quent): ?>
    <?php $form = ActiveForm::begin(['id' => 'edu', 'options' => [
        'enctype' => 'multipart/form-data']]);?>
    <?php switch (TestQuestionHelper::questionType($quent->question_id)):
        case TestQuestionHelper::TYPE_SELECT: ?>
            <?= $this->render('@frontend/views/test/type/select', ['quent' => $quent]) ?>
            <?php break; ?>
        <?php case TestQuestionHelper::TYPE_SELECT_ONE: ?>
            <?= $this->render('@frontend/views/test/type/select-one', ['quent' => $quent]) ?>
            <?php break; ?>
        <?php case TestQuestionHelper::TYPE_MATCHING: ?>
            <?= $this->render('@frontend/views/test/type/matching', ['quent' => $quent]) ?>
            <?php break; ?>
        <?php case TestQuestionHelper::TYPE_ANSWER_DETAILED: ?>
            <?= $this->render('@frontend/views/test/type/detailed', ['quent' => $quent]) ?>
            <?php break; ?>
        <?php case TestQuestionHelper::TYPE_ANSWER_SHORT: ?>
            <?= $this->render('@frontend/views/test/type/short', ['quent' => $quent]) ?>
            <?php break; ?>
        <?php case TestQuestionHelper::TYPE_FILE: ?>
            <?= $this->render('@frontend/views/test/type/file', ['quent' => $quent]) ?>
            <?php break; ?>
        <?php default: ?>
            <?= $this->render('@frontend/views/test/type/cloze', ['quent' => $quent]) ?>
        <?php endswitch; ?>
        <?= Html::hiddenInput('AnswerAttempt[key]',  $quent->question_id) ?>
        <?= Html::hiddenInput('AnswerAttempt[keyTqId]', $quent->tq_id) ?>
        <p>
         <?= Html::submitButton("Далее", ['class'=>'btn btn-success']) ?>  <?= Html::a("Зввершить", ['/test-attempt/end', 'test_id'=> $test->id],
             ['data' => ['confirm' => 'Вы действительно хотите завершить заочный тур?', 'method' => 'POST'], 'class' =>'btn btn-primary'] )  ?>
        </p>
    <?php ActiveForm::end();?>
<?php  endforeach;?>
        <?= \yii\widgets\LinkPager::widget(['pagination' => $pages]); ?>
    </center>
    </div>
    </div>

