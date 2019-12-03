<?php
use testing\helpers\AnswerHelper;
use yii\helpers\Html;
use testing\helpers\TestQuestionHelper;
/* @var $quent testing\models\TestAndQuestions */
?>
<h4><?= TestQuestionHelper::questionTextName($quent->question_id) ?></h4>
<?php foreach (AnswerHelper::answerList($quent->question_id) as $index => $name): ?>
    <p><?= $name ?>
        <?= Html::dropDownList("AnswerAttempt[matching][$index]", [], AnswerHelper::answerMatchingList($quent->question_id))?> </p>
<?php endforeach; ?>
