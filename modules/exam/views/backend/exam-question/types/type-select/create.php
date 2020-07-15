<?php

use modules\exam\assets\questions\QuestionSelectTypeAsset;
use wbraganca\dynamicform\DynamicFormWidget;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model testing\forms\question\TestQuestionTypesForm */
/* @var $model->question  testing\forms\question\TestQuestionForm */
/* @var $model->answer  testing\forms\question\TestAnswerForm */


$this->title = 'Создать "Вариант(ы)"';
$this->params['breadcrumbs'][] = ['label' => 'Вопросы',
    'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<?= $this->render('_form',['model'=> $model ]);

