<?php

use yii\helpers\Html;
use testing\helpers\TestQuestionHelper;
use yii\bootstrap\ActiveForm;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $pages integer */
/* @var $time string */
/* @var $models yii\data\ActiveDataProvider */
/* @var $quent \modules\exam\models\ExamQuestion */
/* @var $test \modules\exam\models\ExamTest */
/* @var $attempt \modules\exam\models\ExamAttempt */


$url = Url::to(['exam-attempt/end', 'test_id' => $test->id]);
?>
<div class="container gray">
    <div class="row">
        <div class="row">
            <div class="col-md-10 col-md-offset-1 white mt-50 dashedBlue">
                <div class="row">
                    <div class="col-md-5 mt-10">
                        <?= \yii\widgets\LinkPager::widget(['pagination' => $pages, 'lastPageLabel'=> true, 'maxButtonCount' => 7]); ?>
                    </div>
                    <div class="col-md-4 mt-20 fs-15">
                        Оставшееся время:<br/><span
                                class="pl-20"><?= $this->render('_time', ['time' => $attempt->end, 'url'=> $url]) ?></span>
                    </div>
                    <div class="col-md-3 mt-30">
                        <?= Html::a("Завершить экзамен", $url,
                            ['data' => ['confirm' => 'Вы действительно хотите завершить заочный тур?', 'method' => 'POST'], 'class' => 'btn btn-primary']) ?>
                    </div>
                    <?php foreach ($models as $quent): ?>
                </div>
                <hr/>
                <div class="row">
                    <div class="col-md-10 col-md-offset-1">
                        <?php $form = ActiveForm::begin(['id' => 'edu', 'options' => [
                            'enctype' => 'multipart/form-data']]); ?>
                        <?php switch ($quent->question->type_id):
                            case TestQuestionHelper::TYPE_SELECT: ?>
                                <?= $this->render('type/select', ['quent' => $quent]) ?>
                                <?php break; ?>
                            <?php case TestQuestionHelper::TYPE_SELECT_ONE: ?>
                                <?= $this->render('type/select-one', ['quent' => $quent]) ?>
                                <?php break; ?>
                            <?php case TestQuestionHelper::TYPE_MATCHING: ?>
                                <?= $this->render('type/matching', ['quent' => $quent]) ?>
                                <?php break; ?>
                            <?php case TestQuestionHelper::TYPE_ANSWER_DETAILED: ?>
                                <?= $this->render('type/detailed', ['quent' => $quent]) ?>
                                <?php break; ?>
                            <?php case TestQuestionHelper::TYPE_ANSWER_SHORT: ?>
                                <?= $this->render('type/short', ['quent' => $quent]) ?>
                                <?php break; ?>
                            <?php case TestQuestionHelper::TYPE_FILE: ?>
                                <?= $this->render('type/file', ['quent' => $quent]) ?>
                                <?php break; ?>
                            <?php default: ?>
                                <?= $this->render('type/cloze', ['quent' => $quent]) ?>
                            <?php endswitch; ?>
                        <?= Html::hiddenInput('AnswerAttempt[key]', $quent->question_id) ?>
                        <?= Html::hiddenInput('AnswerAttempt[keyTqId]', $quent->tq_id) ?>
                        <div class="row mt-10">
                            <div class="col-md-4 col-md-offset-4 mt-30 mb-20">
                                <?= Html::submitButton("Сохранить ответ", ['class' => 'btn btn-success btn-lg btn-block']) ?>
                            </div>
                        </div>
                        <?php ActiveForm::end(); ?>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?= \modules\exam\widgets\exam\TestResultTableWidget::widget(['attemptId'=> $attempt->id, 'urlTest' => 'exam-test/view']) ?>

