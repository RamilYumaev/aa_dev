<?php
use testing\helpers\AnswerHelper;
use yii\helpers\Html;
use testing\helpers\TestQuestionHelper;
use testing\helpers\QuestionPropositionHelper;
/* @var $quent testing\models\TestAndQuestions */
?>
    <?= TestQuestionHelper::questionTextName($quent->question_id) ?>
    <?php $a= yii\helpers\Json::decode($quent->result); ?>
    <?php foreach (QuestionPropositionHelper::questionPropositionList($quent->question_id) as $index => $item): ?>
    <?php if (QuestionPropositionHelper::type($index) == TestQuestionHelper::CLOZE_SELECT) :
           $drop = Html::dropDownList("AnswerAttempt[select-cloze][$index]", $a['select-cloze'][$index] ?? [], \testing\helpers\AnswerClozeHelper::answerMatchingList($index)); ?>
            <?= QuestionPropositionHelper::isStart($index) ?  $drop . $item :  $item . $drop ?>
    <?php elseif (QuestionPropositionHelper::type($index) == TestQuestionHelper::CLOZE_TEXT):
             $input = Html::textInput("AnswerAttempt[answer-cloze][$index]", $a['answer-cloze'][$index] ?? '', ['class'=>'form-control'] )?>
            <?= QuestionPropositionHelper::isStart($index) ?  $input . $item :  $item . $input ?>
        <?php else:?>
           <?= $item ?>
    <?php endif; ?>
    <?php endforeach; ?>
