<?php

use backend\widgets\adminlte\Box;
use modules\entrant\helpers\BlockRedGreenHelper;
use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model modules\entrant\models\Agreement */
/* @var $cg modules\entrant\models\StatementCg */
/* @var $cgs \yii\db\ActiveRecord */
?>
<?php if ($model) :
    Box::begin(
        ["header" => "Договор о целовом обучении", "type" => Box::TYPE_WARNING,
            "collapsable" => true,
        ]
    ); ?>
    <?= DetailView::widget([
    'options' => ['class' => 'table table-bordered detail-view'],
    'model' => $model,
    'attributes' => [
        ['label' => 'Заказчик', 'value' => $model->organization ? $model->fullOrganization : ''],
        ['label' => 'Работодатель', 'value' => $model->organizationWork ? $model->fullOrganizationWork : ''],
        'number',
        'date:date',
    ]
]) ?>
    <?php foreach ($cgs as $cg) : ?>
        <?= $cg->cg->fullNameB;?>
    <?php endforeach; ?>
    <?php Box::end(); endif; ?>
