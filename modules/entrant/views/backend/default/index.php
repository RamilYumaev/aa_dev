<?php
/* @var $this yii\web\View */

use modules\dictionary\helpers\DictDefaultHelper;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use yii\helpers\Html;
/* @var $this yii\web\View */
/* @var $searchModel modules\entrant\searches\ProfilesStatementSearch/
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Абитуриенты';
$this->params['breadcrumbs'][] = $this->title;

?>
<div>
    <div class="box">
        <div class="box-body">
            <?= GridView::widget([
                'dataProvider' => $dataProvider,
                'filterModel' => $searchModel,
                'columns' => [
                    ['class' => \yii\grid\SerialColumn::class],
                    'last_name', 'first_name', 'patronymic',
                    'gender', 'country_id', 'region_id', 'phone',
                    ['value' => function($model) {
                      return Html::a("Просмотр", ['full', 'user' => $model->user_id], ['class' => 'btn btn-info']);
                      },
                      'format' => "raw",
                      ]
                ]
            ]); ?>
        </div>
    </div>
</div>