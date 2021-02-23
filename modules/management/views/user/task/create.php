<?php
/* @var $this yii\web\View */
/* @var $model modules\management\forms\DictTaskForm*/
/* @var $schedule modules\management\models\Schedule*/
$this->title = "Задача. Добавление.";

$this->params['breadcrumbs'][] = ['label' => 'Задачи', 'url' => ['task/index']];
$this->params['breadcrumbs'][] = $this->title;

?>
<?= $this->render('_form', ['model'=> $model,  'schedule'=> $schedule,] )?>

