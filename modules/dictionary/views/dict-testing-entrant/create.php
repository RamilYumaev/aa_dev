<?php
/* @var $this yii\web\View */
/* @var $model modules\dictionary\forms\DictPostEducationForm */
$this->title = "Справочник подзадач для тестирования. Добавление.";

$this->params['breadcrumbs'][] = ['label' => 'Справочник подзадач для тестирования', 'url' => ['dict-testing-entrant/index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<?= $this->render('_form', ['model'=> $model] )?>

