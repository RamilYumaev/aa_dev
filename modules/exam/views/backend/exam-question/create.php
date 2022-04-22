<?php

use modules\exam\assets\questions\QuestionSelectTypeOneAsset;
use testing\helpers\TestQuestionHelper;

/* @var $this yii\web\View */
/* @var $model testing\forms\question\TestQuestionTypesForm | \modules\exam\forms\question\ExamQuestionForm */
?>
<?php if(property_exists($model::className(), 'type') && $model->type == TestQuestionHelper::TYPE_SELECT_ONE ) :?>
<?= $this->render('types/type-select-one/create',['model'=> $model ]); ?>
<?php elseif(property_exists($model::className(), 'type_id') &&
    $model->type_id == TestQuestionHelper::TYPE_ANSWER_DETAILED ) :?>
    <?= $this->render('types/type-answer-detailed/create',['model'=> $model ]); ?>
<?php elseif(property_exists($model::className(), 'type_id') &&
    $model->type_id == TestQuestionHelper::TYPE_FILE ) :?>
<?= $this->render('types/type-file/create',['model'=> $model ]); ?>
<?php elseif(property_exists($model::className(), 'type') && $model->type == TestQuestionHelper::TYPE_ANSWER_SHORT ) :?>
    <?= $this->render('types/type-answer-short/create',['model'=> $model ]); ?>
<?php elseif(property_exists($model::className(), 'type') && $model->type == TestQuestionHelper::TYPE_SELECT ) :?>
    <?= $this->render('types/type-select/create',['model'=> $model ]); ?>
<?php elseif(property_exists($model::className(), 'type') && $model->type == TestQuestionHelper::TYPE_MATCHING ) :?>
    <?= $this->render('types/type-matching/create',['model'=> $model ]); ?>
<?php elseif(property_exists($model->question::className(), 'type_id')
    && $model->question->type_id == TestQuestionHelper::TYPE_CLOZE ) :?>
    <?= $this->render('types/type-nested/create',['model'=> $model ]); ?>
<?php endif; ?>

