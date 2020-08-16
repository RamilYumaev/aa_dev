<?php
/* @var $this yii\web\View */
/* @var $model modules\dictionary\forms\DictExaminerForm*/
$this->title = "Справочник председателей экзаменационных комиссий. Добавление.";

$this->params['breadcrumbs'][] = ['label' => 'Справочник председателей экзаменационных комиссий', 'url' => ['dict-examiner/index']];
$this->params['breadcrumbs'][] = $this->title;

?>
<?= $this->render('_form', ['model'=> $model] )?>

