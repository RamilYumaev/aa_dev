<?php
/* @var $this yii\web\View */
/* @var $model modules\entrant\forms\UserDisciplineCseForm */

$this->title = "Результаты ЕГЭ. Добавление.";

$this->params['breadcrumbs'][] = ['label' => 'Персональная карточка поступающего', 'url' => ['default/index']];
$this->params['breadcrumbs'][] = ['label' => 'ЕГЭ', 'url' => ['default/cse']];
$this->params['breadcrumbs'][] = $this->title;

?>
<?= $this->render('_form_cse', ['model'=> $model])?>

