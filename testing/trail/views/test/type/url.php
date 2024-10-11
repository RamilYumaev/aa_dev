<?php
use testing\helpers\AnswerHelper;
use yii\helpers\Html;
use testing\helpers\TestQuestionHelper;
/* @var $quent testing\models\TestAndQuestions */
?>
<?= $quent->question->text ?>
<?php $a= yii\helpers\Json::decode($quent->result); ?>
<?= Html::textInput('AnswerAttempt[url]', $a['url'] ?? "", ['class'=>'form-control'] )?>
