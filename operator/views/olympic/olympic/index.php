<?php

use dictionary\helpers\DictSpecializationHelper;
use dictionary\helpers\DictFacultyHelper;
use dictionary\helpers\DictSpecialityHelper;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $searchModel olympic\forms\search\OlympicSearch*/
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Олимпиады/конкурсы';
$this->params['breadcrumbs'][] = $this->title;
?>
<?= \operator\widgets\olimpic\OlympicWidget::widget()?>
