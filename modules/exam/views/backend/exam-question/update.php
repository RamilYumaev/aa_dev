<?php

use modules\exam\assets\questions\QuestionSelectTypeOneAsset;
use testing\helpers\TestQuestionHelper;

/* @var $this yii\web\View */
/* @var $model modules\exam\forms\question\ExamTypeQuestionAnswerForm*/
/* @var $question \modules\exam\models\ExamQuestion */
?>

<?php if($question->type_id == TestQuestionHelper::TYPE_SELECT_ONE ) :?>
    <?= $this->render('types/type-select-one/update',['model'=> $model ]); ?>
<?php elseif($question->type_id == TestQuestionHelper::TYPE_ANSWER_DETAILED ) :?>
    <?= $this->render('types/type-answer-detailed/update',['model'=> $model ]); ?>
<?php elseif($question->type_id == TestQuestionHelper::TYPE_FILE ) :?>
    <?= $this->render('types/type-file/update',['model'=> $model ]); ?>
<?php elseif( $question->type_id == TestQuestionHelper::TYPE_ANSWER_SHORT ) :?>
    <?= $this->render('types/type-answer-short/update',['model'=> $model ]); ?>
<?php elseif( $question->type_id == TestQuestionHelper::TYPE_SELECT ) :?>
    <?= $this->render('types/type-select/update',['model'=> $model ]); ?>
<?php elseif( $question->type_id == TestQuestionHelper::TYPE_MATCHING ) :?>
    <?= $this->render('types/type-matching/update',['model'=> $model ]); ?>
<?php elseif( $question->type_id == TestQuestionHelper::TYPE_CLOZE ) :?>
    <?= $this->render('types/type-nested/update',['model'=> $model ]); ?>
<?php endif; ?>


