<?php
/* @var $this yii\web\View */
/* @var $model modules\management\forms\DateWorkForm */
$this->title = "Выходные дни. Добавление.";

$this->params['breadcrumbs'][] = ['label' => 'Выходные дни', 'url' => ['date-feast/index']];
$this->params['breadcrumbs'][] = $this->title;

?>
<?= $this->render('_form', ['model'=> $model] )?>

