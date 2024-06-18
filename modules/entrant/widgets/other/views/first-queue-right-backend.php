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
        "header" => "Документ, подтверждающий право первоочередного приема в соответствии с частью 4 статьи 68 Федерального закона «Об образовании в Российской Федерации»",
        "type" => Box::TYPE_DANGER,
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

