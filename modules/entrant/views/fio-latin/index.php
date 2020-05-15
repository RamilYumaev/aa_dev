<?php
/* @var $this yii\web\View */
/* @var $model modules\entrant\forms\FIOLatinForm */
/* @var $fio modules\entrant\models\FIOLatin */

$this->title = "ФИО на латинском ". ($fio ? "Редактирование": "Добавление").".";
$this->params['breadcrumbs'][] = ['label' => 'Персональная карточка поступающего', 'url' => ['default/index']];
$this->params['breadcrumbs'][] = $this->title; ?>
<?= $this->render('_form', ['model'=> $model] )?>

