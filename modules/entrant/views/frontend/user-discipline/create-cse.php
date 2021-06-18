<?php
/* @var $this yii\web\View */
/* @var $model modules\entrant\forms\UserDisciplineCseForm */

$this->title = "Результаты ЕГЭ. Добавление.";

$this->params['breadcrumbs'][] = ['label' => 'Персональная карточка поступающего', 'url' => ['default/index']];
$this->params['breadcrumbs'][] = ['label' => 'Уровни образования', 'url' => ['/abiturient/anketa/step2']];
$this->params['breadcrumbs'][] = ['label' => 'ЕГЭ', 'url' => ['user-discipline/index']];
$this->params['breadcrumbs'][] = $this->title;

?>
<?= $this->render('_form_cse', ['model'=> $model])?>

