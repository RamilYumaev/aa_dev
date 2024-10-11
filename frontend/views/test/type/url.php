<?php
use yii\helpers\Html;
use testing\helpers\TestQuestionHelper;
/* @var $quent testing\models\TestResult */
?>
    <?= TestQuestionHelper::questionTextName($quent->question_id) ?>
<?php $a= yii\helpers\Json::decode($quent->result); ?>
<?= Html::textInput('AnswerAttempt[url]', $a['url'] ?? "", ['class'=>'form-control'] )?>
