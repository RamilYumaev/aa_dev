<?php
use backend\widgets\adminlte\grid\GridView;
use yii\grid\ActionColumn;

/* @var $this yii\web\View */

$this->title = "Банк вопросов";
?>
<?= $this->render('_questions-type-link') ?>
<div class="row">
    <div class="col-md-12">
        <div class="box">
            <div class="box-body">
                <?= GridView::widget([
                    'dataProvider' => $dataProvider,
                    'columns' => [
                        ['class' => \yii\grid\SerialColumn::class],
                        'title',
                        ['attribute' => 'type_id',
                            'value' => function($model) {
                    return \testing\helpers\TestQuestionHelper::typeName($model->type_id);
                            }],
                        'text:raw',
                        ['class' => ActionColumn::class],
                    ]
                ]); ?>
            </div>
        </div>
    </div>
</div>