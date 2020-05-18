<?php
/* @var $this yii\web\View */
/* @var $model modules\entrant\forms\AddressForm */
$this->title = "Адреса. Добавление.";

$this->params['breadcrumbs'][] = ['label' => 'Персональная карточка поступающего', 'url' => ['default/index']];
$this->params['breadcrumbs'][] = $this->title;

?>
<?= $this->render('_form', ['model'=> $model] )?>

