<?php
/* @var $this yii\web\View */
/* @var $model modules\entrant\forms\AddressForm */
$this->title = "Экзамен. Добавление.";

$this->params['breadcrumbs'][] = ['label' => 'Экзамены', 'url' => ['exam/index']];
$this->params['breadcrumbs'][] = $this->title;

?>
<?= $this->render('_form', ['model'=> $model] )?>

