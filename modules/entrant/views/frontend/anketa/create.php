<?php
/* @var $this yii\web\View */
/* @var $model modules\entrant\forms\DocumentEducationForm */

\common\user\assets\AddSchoolAsset::register($this);
$this->title = "Определение условий подачи документов. Шаг 1.";

$this->params['breadcrumbs'][] = $this->title;

?>
<?= $this->render('_form', ['model'=> $model] )?>

