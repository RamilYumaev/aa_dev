<?php
/* @var $this yii\web\View */
/* @var $model \modules\entrant\modules\ones_2024\model\FileSS */
$this->title = "Файл. Добавление ";
$this->params['breadcrumbs'][] = ['label' => 'Файлы', 'url' => ['default/index']];
$this->params['breadcrumbs'][] = $this->title;

?>
<?= $this->render('_form', ['model'=> $model] )?>

