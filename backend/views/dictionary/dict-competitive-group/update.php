<?php

use kartik\select2\Select2;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $competitiveGroup dictionary\models\DictCompetitiveGroup */
/* @var $model dictionary\forms\DictCompetitiveGroupEditForm */
/* @var $form yii\widgets\ActiveForm */

$this->title = 'Обновить: ';
$this->params['breadcrumbs'][] = ['label' => 'Конкурсные группы', 'url' => ['index']];
$this->params['breadcrumbs'][] = 'Обновить';
?>
<?= $this->render('_form', ['model'=> $model]); ?>

