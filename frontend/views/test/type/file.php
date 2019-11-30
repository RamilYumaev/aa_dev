<?php
use yii\helpers\Html;
use testing\helpers\TestQuestionHelper;
/* @var $quent testing\models\TestAndQuestions */
?>
    <h4><?= TestQuestionHelper::questionTextName($quent->question_id) ?></h4>
<?= Html::fileInput('file')?>