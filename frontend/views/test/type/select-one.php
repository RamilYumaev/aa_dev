<?php
use testing\helpers\AnswerHelper;
use yii\helpers\Html;
use testing\helpers\TestQuestionHelper;

/* @var $quent testing\models\TestAndQuestions */
?>
<h4><?= TestQuestionHelper::questionTextName($quent->question_id) ?></h4>
<?php $a= yii\helpers\Json::decode($quent->result); ?>
<?= Html::radioList('AnswerAttempt[select-one]' , $a ?? [] , AnswerHelper::answerList($quent->question_id))?>
