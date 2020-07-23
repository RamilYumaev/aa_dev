<?php

use modules\exam\helpers\ExamAnswerHelper;
use testing\helpers\AnswerHelper;
use yii\helpers\Html;
use testing\helpers\TestQuestionHelper;

/* @var $quent testing\models\TestAndQuestions */
?>
<?= $quent->question->text ?>
<p>Выберите один правильный ответ:</p>
<?php $a= yii\helpers\Json::decode($quent->result); ?>
<?= Html::radioList('AnswerAttempt[select-one]' , $a ?? [] , ExamAnswerHelper::answerList($quent->question_id),
    [
        'itemOptions' => [
            'labelOptions' => ['class' => 'checkbox'],
        ],
    ])?>
