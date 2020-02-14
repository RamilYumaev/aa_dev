<?php
use testing\helpers\AnswerHelper;
use yii\helpers\Html;
use testing\helpers\TestQuestionHelper;

/* @var $quent testing\models\TestAndQuestions */
?>
<?= TestQuestionHelper::questionTextName($quent->question_id) ?>
<p>Выберите один правильный ответ:</p>
<?php $a= yii\helpers\Json::decode($quent->result); ?>
<?= Html::radioList('AnswerAttempt[select-one]' , $a ?? [] , AnswerHelper::answerList($quent->question_id),
    [
        'itemOptions' => [
            'labelOptions' => ['class' => 'checkbox'],
        ],
    ])?>
