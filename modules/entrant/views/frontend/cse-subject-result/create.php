<?php
/* @var $this yii\web\View */
/* @var $model modules\entrant\forms\DocumentEducationForm */
/* @var $isKeys array */

$this->title = "Результаты ЕГЭ. Добавление.";

$this->params['breadcrumbs'][] = ['label' => 'Онлайн-регистрация', 'url' => ['default/index']];
$this->params['breadcrumbs'][] = ['label' => 'ЕГЭ', 'url' => ['default/cse']];
$this->params['breadcrumbs'][] = $this->title;

?>
<?= $this->render('_form', ['model'=> $model, 'isKeys' => $isKeys] )?>

