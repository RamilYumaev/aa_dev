<?php

use modules\exam\assets\questions\QuestionSelectTypeOneAsset;

/* @var $this yii\web\View */
/* @var $model modules\exam\forms\question\ExamTypeQuestionAnswerForm */



$this->title = 'Редактировать "Вариант"';
$this->params['breadcrumbs'][] = ['label' => 'Вопросы теста "Вариант"', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

?>
<?= $this->render('_form',['model'=> $model ]);


