<?php
/* @var $this yii\web\View */
/* @var $model modules\management\forms\PostManagementForm */
$this->title = "Сопоставление (отдел, должность, рабочая ставка). Добавление.";

$this->params['breadcrumbs'][] = ['label' => 'Сопоставление (отдел, должность, рабочая ставка)', 'url' => ['post-management/index']];
$this->params['breadcrumbs'][] = $this->title;

?>
<?= $this->render('_form', ['model'=> $model] )?>

