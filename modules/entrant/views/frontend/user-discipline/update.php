<?php
/* @var $this yii\web\View */
/* @var $model modules\entrant\forms\DocumentEducationForm */
/* @var $userDiscipline modules\entrant\models\UserDiscipline*/


$this->title = "Результаты ".$userDiscipline->nameShortType.". Редактирование.";
$this->params['breadcrumbs'][] = ['label' => 'Персональная карточка поступающего', 'url' => ['default/index']];
$this->params['breadcrumbs'][] = ['label' => 'ЕГЭ/ЦТ', 'url' => ['user-discipline/index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<?= $this->render('_form_cse', ['model'=> $model] )?>
