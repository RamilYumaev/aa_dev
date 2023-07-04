<?php
/* @var $this yii\web\View */
/* @var $model modules\entrant\forms\AverageScopeSpoForm */

$this->title = "Средний балл аттестата ". ($model->model ? "Редактирование": "Добавление").".";
$this->params['breadcrumbs'][] = ['label' => 'Онлайн-регистрация', 'url' => ['default/index']];
$this->params['breadcrumbs'][] = $this->title; ?>
<?= $this->render('_form', ['model'=> $model])?>

