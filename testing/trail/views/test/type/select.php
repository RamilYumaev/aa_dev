<?php

use testing\helpers\AnswerHelper;
use yii\helpers\Html;
use testing\helpers\TestQuestionHelper;

/* @var $quent testing\models\TestAndQuestions */
?>
<?= $quent->question->text ?>
<p>Выберите один или несколько правильных ответов:</p>
    <?php $a = yii\helpers\Json::decode($quent->result, true);
$q = $a ? array_map(function ($var) {
    return is_numeric($var) ? (int)$var : $var;
}, $a['select']) : '';
?>
<div class="row mt-10">
    <div class="col-md-6 col-md-offset-3 text-left white">
        <?= Html::checkboxList('AnswerAttempt[select]', $q ?? [], AnswerHelper::answerList($quent->question_id), [
            'itemOptions' => [
                'labelOptions' => ['class' => 'checkbox'],
            ],
        ]) ?>
    </div>
</div>