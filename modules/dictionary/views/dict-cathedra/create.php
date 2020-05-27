<?php
/* @var $this yii\web\View */
/* @var $model modules\dictionary\forms\DictCathedraForm */
$this->title = "Кафедра. Добавление.";

$this->params['breadcrumbs'][] = ['label' => 'Кафедры', 'url' => ['dict-cathedra/index']];
$this->params['breadcrumbs'][] = $this->title;

?>
<?= $this->render('_form', ['model'=> $model] )?>

