<?php
/* @var $this yii\web\View */
/* @var $model modules\dictionary\forms\TestingEntrantForm */
$this->title = "Задачи для тестирования. Добавление.";

$this->params['breadcrumbs'][] = ['label' => 'Задачи для тестирования', 'url' => ['testing-entrant/index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<?= $this->render('_form', ['model'=> $model] )?>

