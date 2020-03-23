<?php
/* @var $this yii\web\View */
/* @var $model modules\entrant\forms\DocumentEducationForm */

\common\user\assets\UpdateSchoolAsset::register($this);

$this->title = "Анкета. Редактирование.";
$this->params['breadcrumbs'][] = $this->title;
?>
<?= $this->render('_form', ['model'=> $model] )?>
