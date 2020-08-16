<?php

/* @var $this yii\web\View */
/* @var $model testing\forms\question\TestQuestionTypesForm */

$this->title = 'Создать "Краткий ответ"';
$this->params['breadcrumbs'][] = ['label' => 'Вопросы',
    'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<?= $this->render('_form',['model'=> $model ]);