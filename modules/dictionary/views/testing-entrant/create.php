<?php
/* @var $this yii\web\View */
/* @var $model modules\dictionary\forms\TestingEntrantForm */
$this->title = "QA. Добавление.";

$this->params['breadcrumbs'][] = ['label' => 'QA', 'url' => ['testing-entrant/index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<?= $this->render('_form', ['model'=> $model] )?>

