<?php

use backend\widgets\adminlte\Box;
use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $other modules\entrant\models\OtherDocument */
/* @var $type  string */

$noPatriot = $type !== "patriot"; ?>
<?php  if ($other) :
    Box::begin(
    ["header" => $noPatriot ? "Документ, подтверждающий льготы." :
        "Документ, подтверждающий принадлежность к соотечественникам за рубежом" , "type" => $noPatriot ? Box::TYPE_PRIMARY: Box::TYPE_WARNING,
        "collapsable" => true,
    ]
);

                $column = [
                    'series',
                    'number',
                    'date:date',
                ];

                if ($noPatriot) {
                    array_push($column, ['label' => $other->getAttributeLabel('type'),
                        'value' => $other->typeName,],
                        ['label' => $other->getAttributeLabel('exemption_id'),
                            'value' => $other->exemption,]);
                }
                ?>
                <?= DetailView::widget([
                'options' => ['class' => 'table table-bordered detail-view'],
                'model' => $other,
                'attributes' => $column
            ]) ?>
<?php Box::end(); endif;  ?>
