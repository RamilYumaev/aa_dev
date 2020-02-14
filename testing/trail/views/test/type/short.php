<?php
use testing\helpers\AnswerHelper;
use yii\helpers\Html;
use testing\helpers\TestQuestionHelper;
/* @var $quent testing\models\TestAndQuestions */
?>
    <?= TestQuestionHelper::questionTextName($quent->question_id) ?>
<?php $a= yii\helpers\Json::decode($quent->result); ?>
<?= Html::textInput('AnswerAttempt[short]', $a['short'] ?? "", ['class'=>'form-control'] )?>