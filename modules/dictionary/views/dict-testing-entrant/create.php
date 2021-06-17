<?php
/* @var $this yii\web\View */
/* @var $model modules\dictionary\forms\DictPostEducationForm */
$this->title = "Задачи. Добавление.";

$this->params['breadcrumbs'][] = ['label' => 'Задачи', 'url' => ['dict-testing-entrant/index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<?= $this->render('_form', ['model'=> $model] )?>

