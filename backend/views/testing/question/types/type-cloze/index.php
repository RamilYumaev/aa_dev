<?php
use backend\widgets\adminlte\grid\GridView;
use yii\grid\ActionColumn;
use yii\helpers\Html;

/* @var $searchModel testing\forms\question\search\QuestionSearch */
$this->title = "с вложенным ответом";
?>
<?= $this->render('@backend/views/testing/question/_questions-type-link') ?>
<div class="row">
    <div class="col-md-12">
        <div class="box">
            <div class="box-header">
                <?=   Html::a('Создать', ['create'], [ 'class'=>'btn btn-success']); ?>
            </div>
            <div class="box-body">
                <?= GridView::widget([
                    'dataProvider' => $dataProvider,
                    'filterModel' => $searchModel,
                    'columns' => [
                        ['class' => \yii\grid\SerialColumn::class],
                        'title',
                        'text:raw',
                        ['class' => ActionColumn::class],
                    ]
                ]); ?>
            </div>
        </div>
    </div>
</div>