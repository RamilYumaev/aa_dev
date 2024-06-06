<?php
/* @var $this yii\web\View */
/* @var $exam modules\exam\models\Exam */
/* @var $model modules\exam\forms\ExamForm */

$this->title = "Экзамен/Аттестация. ".$exam->discipline->name.". Редактирование";
$this->params['breadcrumbs'][] = ['label' => 'Экзамен/Аттестация', 'url' => ['exam/index']];
$this->params['breadcrumbs'][] = ['label' => 'Экзамен. '.$exam->discipline->name, 'url' => ['exam/view', 'id'=> $exam->id]];
$this->params['breadcrumbs'][] = $this->title;
?>
<?= $this->render('_form', ['model'=> $model] )?>
