<?php
use yii\helpers\Html;
use testing\helpers\TestQuestionHelper;
/* @var $quent testing\models\TestResult */
?>
    <?= TestQuestionHelper::questionTextName($quent->question_id) ?>
<?php $a= yii\helpers\Json::decode($quent->result); ?>
<?= Html::textarea('AnswerAttempt[detailed]', $a['detailed'] ?? "", ['cols'=>105, "rows"=>10] )?>
