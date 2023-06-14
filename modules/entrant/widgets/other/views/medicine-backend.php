<?php

use backend\widgets\adminlte\Box;
use modules\entrant\helpers\BlockRedGreenHelper;
use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $other modules\entrant\models\OtherDocument */
/* @var $type  string */
?>

<?php
if ($other) :
    Box::begin(
    [
        "header" => "Заключение об
                    отсутсвии противопоказаний для обучения (медицинская справка 086у; дествующая медицинская книжка)",
        "type" => Box::TYPE_PRIMARY,
        "filled" => true,]);
    $column = [
        ['label' => $other->getAttributeLabel('type'),
            'value' => $other->typeName,],
        'series',
        'number',
        'authority',
        'date:date',
    ];
?>
    <?= DetailView::widget([
    'options' => ['class' => 'table table-bordered detail-view'],
    'model' => $other,
    'attributes' => $column
]) ?>

<?php Box::end(); endif; ?>