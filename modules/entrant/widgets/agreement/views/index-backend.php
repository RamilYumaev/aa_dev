<?php

use backend\widgets\adminlte\Box;
use modules\entrant\helpers\BlockRedGreenHelper;
use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model modules\entrant\models\Agreement */
?>
<?php if ($model) :
    Box::begin(
        ["header" => "Договор о целовом обучении"  , "type" => Box::TYPE_WARNING,
            "collapsable" => true,
        ]
    );?>
    <?= DetailView::widget([
                'options' => ['class' => 'table table-bordered detail-view'],
                'model' => $model,
                'attributes' => [
                    'organization.name',
                    'number',
                    'date:date',
                ]
            ]) ?>
            <?php Box::end(); endif; ?>
