<?php
/* @var $this yii\web\View */
/* @var $model modules\management\forms\RegistryDocumentForm*/
$this->title = "Реестр документов. Добавление.";

$this->params['breadcrumbs'][] = ['label' => 'Реестр документов', 'url' => ['registry-document/index']];
$this->params['breadcrumbs'][] = $this->title;

?>
<?= $this->render('_form', ['model'=> $model] )?>

