
<?php

use modules\transfer\search\TransferSettingSearch;
use yii\grid\GridView;
use yii\helpers\Html;

/** @var $this yii\web\View */
/** @var $searchModel TransferSettingSearch */
/** @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Настройки ПиВо';
?>

<div class="transfer-setting-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(
            'Создать',
            ['create'],
            ['class' => 'btn btn-success']
        ) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,

        'columns' => [
            'id',

            [
                'attribute' => 'finances',
                'format' => 'ntext',
            ],

            [
                'attribute' => 'citizenship',
                'format' => 'ntext',
            ],

            [
                'attribute' => 'semesters',
                'format' => 'ntext',
            ],

            'date_start',
            'date_end',

            [
                'class' => 'yii\grid\ActionColumn',
            ],
        ],
    ]); ?>

</div>

