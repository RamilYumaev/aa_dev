<?php
use modules\literature\models\UserPersonsLiterature;
use yii\helpers\Html; ?>
<?= $this->render('steps',['step'=>$step, 'isRoute' => $isRoute]) ?>
<div class="container">
    <div class="row">
        <div class="col-md-12 mb-20">
            <?=  Html::a("<< Шаг 4", ['step4'], ['class'=>'btn btn-warning pull-left']) ?>
            <?= Html::a( !$isRoute ? "Закончить" : "Шаг 6 >>", ['step6'], ['class'=>'btn btn-primary pull-right']) ?>
        </div>
    </div>
    <div class="row">
        <div class="col-md-4">
            <h3>Поиск</h3>
            <?= $this->render('form/_search', [
                'model' => $searchModel
            ]) ?>
            <h3>Выбранные сопровождающие</h3>
            <?= \yii\grid\GridView::widget([
                'tableOptions' => ['class' => 'table  table-bordered'],
                'dataProvider' => $provider,
                'columns' => [
                    'personsLiterature.fio',
                    'personsLiterature.post',
                ],
            ]) ?>
        </div>
        <div class="col-md-8">
            <h3>Cопровождающие</h3>
            <?= \yii\grid\GridView::widget([
                'tableOptions' => ['class' => 'table  table-bordered'],
                'dataProvider' => $dataProvider,
                'columns' => [
                        'fio',
                    'post',
                    ['format'=> 'raw',
                        'value' => function (\modules\literature\models\PersonsLiterature $model) use ($userId) {
                           return UserPersonsLiterature::findOne(['persons_literature_id' => $model->id, 'user_id'=> $userId]) ?
                               Html::a("Убрать", ['delete-person', 'id' => $model->id], ['class'=>'btn btn-danger']) : Html::a("Выбрать", ['add-person', 'id' => $model->id], ['class'=>'btn btn-success']);
                    }]
                ],
            ]) ?>
        </div>
        <div class="col-md-12 mb-20">
        <?= Html::a( !$isRoute ? "Закончить" : "Далее", ['step6'], ['class'=>'btn btn-primary btn-lg pull-right']) ?>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12 mb-20">
            <?= \yii\jui\Accordion::widget([
                'options' => ['tag' => 'div'],
                'itemOptions' => ['tag' => 'div'],
                'headerOptions' => ['tag' => 'h3'],
                'clientOptions' => ['collapsible' => true, 'active'=>false],
                'items' => [
                    [
                        'header' => 'Добавить нового сопровождающего',
                        'content' => $this->render('form/_form_person', [
                            'model' => $model
                        ])
                    ]]]) ?>
        </div>
    </div>
</div>

