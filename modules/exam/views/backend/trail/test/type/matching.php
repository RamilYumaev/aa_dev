<?php

use kartik\select2\Select2;
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
        <?=  Select2::widget([
            'name' => "AnswerAttempt[matching][$index]",
            'value' => $a["matching"][$index] ?? null,
            'data' => ExamAnswerHelper::answerMatchingList($quent->question_id),
        ]); ?>
    </p>
<?php endforeach; ?>
