<?php
/* @var $this yii\web\View */
/* @var $model modules\entrant\forms\DocumentEducationForm */

\common\user\assets\UpdateSchoolAsset::register($this);

$this->title = "Определение условий подачи документов. Шаг 1. Редактирование";
$this->params['breadcrumbs'][] = $this->title;
?>
<?= $this->render('_form', ['model'=> $model] )?>
