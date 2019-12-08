<?php
use testing\helpers\AnswerHelper;
use yii\helpers\Html;
use testing\helpers\TestQuestionHelper;
/* @var $quent testing\models\TestAndQuestions */
?>
<h4><?= TestQuestionHelper::questionTextName($quent->question_id) ?></h4>
<?php $a= yii\helpers\Json::decode($quent->result, true);
$q = $a ? array_map(function($var) {return is_numeric($var) ? (int)$var : $var; }, $a['select']) : '';
?>
<?= Html::checkboxList('AnswerAttempt[select]', $q ?? [], AnswerHelper::answerList($quent->question_id)) ?>