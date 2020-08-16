<?php


/* @var $this yii\web\View */
/* @var $model testing\forms\question\TestQuestionTypesForm */

$this->title = 'Редактировать "Вариант(ы)"';
$this->params['breadcrumbs'][] = ['label' => 'Вопросы',
    'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<?= $this->render('_form',['model'=> $model ]);

