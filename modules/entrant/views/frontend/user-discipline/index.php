<?php
/* @var $this yii\web\View */
/* @var $dataProvider \yii\data\ActiveDataProvider */
/* @var $isKeys array */
use yii\helpers\Html;
$this->title = "Результаты ЕГЭ/ЦТ.";
$this->params['breadcrumbs'][] = ['label' => 'Персональная карточка поступающего', 'url' => ['default/index']];
$this->params['breadcrumbs'][] = $this->title;
 ?>
<div class="container">
    <h1><?=$this->title?></h1>
    <p>
        <?= Html::a("Добавить ЕГЭ",
            ["user-discipline/create-cse"], ["class" => "btn btn-primary"]) ?>
        <?= Html::a("Добавить ЦТ",
            ["user-discipline/create-ct"], ["class" => "btn btn-success"]) ?>
    </p>
    <div class="mt-20 table-responsive">
        <?= \yii\grid\GridView::widget([
            'dataProvider' => $dataProvider,
            'columns' =>[
                ['class' => \yii\grid\SerialColumn::class],
                ['header' => 'Предмет', 'value' => 'dictDiscipline.name'],
                ['header' => 'Вид', 'value' => 'nameShortType'],
                'mark',
                'year',
                ['class' => \yii\grid\ActionColumn::class,
                    'template' => "{update} {delete}",
                    'controller'=> 'user-discipline' ]
            ],
        ]) ?>
    </div>
</div>


