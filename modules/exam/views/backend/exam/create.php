<?php
/* @var $this yii\web\View */
/* @var $model modules\entrant\forms\AddressForm */
$this->title = "Экзамен/Аттестация. Добавление.";

$this->params['breadcrumbs'][] = ['label' => 'Экзамен/Аттестация', 'url' => ['exam/index']];
$this->params['breadcrumbs'][] = $this->title;

?>
<?= $this->render('_form', ['model'=> $model] )?>

