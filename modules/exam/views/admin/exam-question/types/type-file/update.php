<?php

/* @var $this yii\web\View */
/* @var $model testing\forms\question\TestQuestionTypesFileForm*/

$this->title = 'Редактировать "Ответ с загрузкой файла"';

$this->params['breadcrumbs'][] = ['label' => 'Вопросы','url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

?>
<?= $this->render('_form',['model'=> $model ]);