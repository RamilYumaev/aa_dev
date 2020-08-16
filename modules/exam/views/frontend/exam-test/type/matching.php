<?php

use modules\exam\helpers\ExamAnswerHelper;
use testing\helpers\AnswerHelper;
use yii\helpers\Html;
use testing\helpers\TestQuestionHelper;
/* @var $quent testing\models\TestAndQuestions */
?>
<?= $quent->question->text ?>
<?php $a= yii\helpers\Json::decode($quent->result);?>
<?php foreach (ExamAnswerHelper::answerList($quent->question_id) as $index => $name): ?>
    <p><?= $name ?>
        <?= Html::dropDownList("AnswerAttempt[matching][$index]", $a["matching"][$index] ?? [], ExamAnswerHelper::answerMatchingList($quent->question_id))?> </p>
<?php endforeach; ?>
