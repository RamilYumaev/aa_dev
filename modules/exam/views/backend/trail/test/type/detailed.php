<?php
use yii\helpers\Html;
use testing\helpers\TestQuestionHelper;
/* @var $quent testing\models\TestResult */
?>
    <?= $quent->question->text ?>
<?php $a= yii\helpers\Json::decode($quent->result); ?>
<?= Html::textarea('AnswerAttempt[detailed]', $a['detailed'] ?? "", ["rows"=>10] )?>
