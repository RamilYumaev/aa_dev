<?php
/* @var $this yii\web\View */
/* @var $model modules\management\forms\DictTaskForm*/
$this->title = "Справочник задач/функций. Добавление.";

$this->params['breadcrumbs'][] = ['label' => 'Справочник задач/функций', 'url' => ['dict-task/index']];
$this->params['breadcrumbs'][] = $this->title;

?>
<?= $this->render('_form', ['model'=> $model] )?>

