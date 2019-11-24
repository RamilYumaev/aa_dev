<?php

/* @var $this yii\web\View */
/* @var $testQuestionGroup testing\models\TestQuestionGroup */

$this->title = $testQuestionGroup->name." ".$testQuestionGroup->year;
$this->params['breadcrumbs'][] = ['label' => 'Группы вопросов', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<?=  \backend\widgets\testing\QuestionWidget::widget(['group_id' => $testQuestionGroup->id]) ?>
