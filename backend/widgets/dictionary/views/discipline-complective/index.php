<?php


use yii\helpers\Html;
use yii\bootstrap\Modal;

/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $competitive_group_id int */

\backend\assets\ModalAsset::register($this)
?>
<div class="box box-primary">
    <div class="box-body">
        <?=Html::a('<span class="glyphicon glyphicon-trash"></span>', ['dictionary/discipline-competitive-group/create',
                   'competitive_group_id' => $competitive_group_id],
        ['data-pjax' => 'w0', 'data-toggle' => 'modal', 'target' => '#modal',]) ?>

        <?= \backend\widgets\adminlte\grid\GridView::widget([
            'dataProvider' => $dataProvider,
            'columns' => [
                ['class' => \yii\grid\SerialColumn::class],
                ['attribute' => 'discipline_id',
                    'value' => function (\dictionary\models\DisciplineCompetitiveGroup $model) {
                        return \dictionary\helpers\DictDisciplineHelper::disciplineName($model->discipline_id);
                    },
                ],
                'priority',
                ['class' => \yii\grid\ActionColumn::class,
                    'controller' => 'dictionary/discipline-competitive-group',
                    'template' => '{update} {delete}',
                ],
            ]
        ]) ?>
    </div>
</div>

<?php Modal::begin(['id'=>'modal',  'header' => "Дисциплины"])?>
<?php
echo "<div id='modalContent'></div>";
Modal::end()?>

