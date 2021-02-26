<?php
/* @var $this yii\web\View */
/* @var $model modules\management\forms\DateWorkForm */
$this->title = "Перенесенные рабочие дни. Добавление.";

$this->params['breadcrumbs'][] = ['label' => 'Перенесенные рабочие дни', 'url' => ['date-work/index']];
$this->params['breadcrumbs'][] = $this->title;

?>
<?= $this->render('_form', ['model'=> $model] )?>

