<?php
/* @var $this yii\web\View */
/* @var $model modules\entrant\modules\ones_2024\model\CgSS */
$this->title = "Конкурсная группа. Добавление ";
$this->params['breadcrumbs'][] = ['label' => '"Конкурсные группы"', 'url' => ['default/index']];
$this->params['breadcrumbs'][] = $this->title;

?>
<?= $this->render('_form', ['model'=> $model] )?>

