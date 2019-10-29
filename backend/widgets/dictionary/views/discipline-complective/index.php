<?php

use dictionary\models\DisciplineCompetitiveGroup;
use yii\helpers\Html;

/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $competitive_group_id int */

?>

<div class="box box-primary">
    <div class="box-body">
        <?= \himiklab\yii2\ajaxedgrid\GridView::widget([
            'dataProvider' => $dataProvider,
            'columns' => [
                ['class' => \yii\grid\SerialColumn::class],
                ['attribute' => 'discipline_id',
                    'value' => function (\dictionary\models\DisciplineCompetitiveGroup $model) {
                        return \dictionary\helpers\DictDisciplineHelper::disciplineName($model->discipline_id);
                    },
                ],
                'priority',
                ],
                'createRoute' => ['dictionary/discipline-competitive-group/create',
                    'competitive_group_id' => $competitive_group_id],
                'updateRoute' => ['dictionary/discipline-competitive-group/update'],
                'deleteRoute'=> ['dictionary/discipline-competitive-group/delete'],
        ]) ?>
    </div>
</div>
