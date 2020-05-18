<?php
/* @var $this yii\web\View */
/* @var $model modules\entrant\forms\PassportDataForm */
$this->title = "Документ, удостоверяющий личность. Добавление.";

$this->params['breadcrumbs'][] = ['label' => 'Персональная карточка поступающего', 'url' => ['default/index']];
$this->params['breadcrumbs'][] = $this->title;

?>
<?= $this->render('_form', ['model'=> $model] )?>

