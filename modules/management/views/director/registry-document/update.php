<?php

/* @var $this yii\web\View */
/* @var $тodel  \modules\management\forms\RegistryDocumentForm */

$this->title = "Реестр документов. Обновление";
$this->params['breadcrumbs'][] = ['label' => 'Реестр документов', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<?= $this->render('@modules/management/views/admin/registry-document/_form', ['model'=> $model] )?>
