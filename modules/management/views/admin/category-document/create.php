<?php
/* @var $this yii\web\View */
/* @var $model modules\management\forms\CategoryDocumentForm*/
$this->title = "Справочник категорий документов. Добавление.";

$this->params['breadcrumbs'][] = ['label' => 'Справочник категорий документов', 'url' => ['category-document/index']];
$this->params['breadcrumbs'][] = $this->title;

?>
<?= $this->render('_form', ['model'=> $model] )?>

