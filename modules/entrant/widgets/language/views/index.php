<?php

use modules\entrant\helpers\LanguageHelper;
use modules\entrant\helpers\BlockRedGreenHelper;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */
?>
<div class="row">
    <div class="col-md-12 <?= BlockRedGreenHelper::colorBg(LanguageHelper::isExits(Yii::$app->user->identity->getId())) ?>">
        <h4>Иностранные языки:</h4>
        <?= Html::a('Добавить', ['language/create'], ['class' => 'btn btn-success mb-10']) ?>
        <?= \yii\grid\GridView::widget([
            'tableOptions' => ['class' => 'table  table-bordered'],
            'dataProvider' => $dataProvider,
            'columns' => [
                ['attribute'=>'language_id', 'value' => 'languageName'],
                ['class'=> \yii\grid\ActionColumn::class, 'controller' => 'language', 'template'=> '{update}{delete}']
            ],
        ]) ?>
    </div>
</div>
