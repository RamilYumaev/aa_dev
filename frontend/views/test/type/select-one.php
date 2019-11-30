<?php
use testing\helpers\AnswerHelper;
use yii\helpers\Html;
use testing\helpers\TestQuestionHelper;

/* @var $quent testing\models\TestAndQuestions */
?>
<h4><?= TestQuestionHelper::questionTextName($quent->question_id) ?></h4>
<?= Html::radioList('select-one', [], AnswerHelper::answerList($quent->question_id))?>
