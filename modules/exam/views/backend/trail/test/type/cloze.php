<?php

use modules\exam\helpers\ExamAnswerNestedHelper;
use modules\exam\helpers\ExamQuestionNestedHelper;
use testing\helpers\AnswerHelper;
use yii\helpers\Html;
use testing\helpers\TestQuestionHelper;
use testing\helpers\QuestionPropositionHelper;
/* @var $quent testing\models\TestAndQuestions */
?>
    <?= $quent->question->text  ?>
    <?php $a= yii\helpers\Json::decode($quent->result); ?>
    <?php foreach (ExamQuestionNestedHelper::questionPropositionList($quent->question_id) as $index => $item): ?>
    <?php if (ExamQuestionNestedHelper::type($index) == TestQuestionHelper::CLOZE_SELECT) :
           $drop = Html::dropDownList("AnswerAttempt[select-cloze][$index]", $a['select-cloze'][$index] ?? [], ExamAnswerNestedHelper::answerMatchingList($index)); ?>
            <?= ExamQuestionNestedHelper::isStart($index) ?  $drop . $item :  $item . $drop ?>
    <?php elseif (ExamQuestionNestedHelper::type($index) == TestQuestionHelper::CLOZE_TEXT):
             $input = Html::textInput("AnswerAttempt[answer-cloze][$index]", $a['answer-cloze'][$index] ?? '', ['class'=>'form-control'] )?>
            <?=ExamQuestionNestedHelper::isStart($index) ?  $input . $item :  $item . $input ?>
        <?php else:?>
           <?= $item ?>
    <?php endif; ?>
    <?php endforeach; ?>
