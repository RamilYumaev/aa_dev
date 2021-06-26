<?php

use dictionary\helpers\DictCompetitiveGroupHelper;
use modules\dictionary\models\SettingEntrant;
use yii\grid\ActionColumn;
use yii\helpers\Html;
use backend\widgets\adminlte\grid\GridView;
use dictionary\models\DictClass;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $searchModel modules\dictionary\searches\RegisterCompetitionListSearch */
$this->title = 'Реестр отправлений сведений в АИС ВУЗ';
$this->params['breadcrumbs'][] = $this->title;
?>
<div>
    <div class="box">
        <div class="table-responsive">
            <?= GridView::widget([
                'dataProvider' => $dataProvider,
                'filterModel'=> $searchModel,
                'columns' => [
                    ['class' => \yii\grid\SerialColumn::class],
                    ['value' => function(\modules\dictionary\models\RegisterCompetitionList $model) {
                        return  $model->isStatusError() || $model->isStatusSend() ? Html::a('Снова отправить', ['setting-entrant/send', 'id' => $model->id],['class'=>'btn btn-warning']) :"";
                    }, 'format' => 'raw'],
                    'se_id',
                    'ais_cg_id',
                    ['attribute'=>'status', 'filter'=> (new \modules\dictionary\models\RegisterCompetitionList())->listStatus(),
                        'value'=> function(\modules\dictionary\models\RegisterCompetitionList $model) {
                              return $model->statusName. ($model->isStatusError() ? '<br />'.$model->error_message:'');
                        }, 'format' => 'raw'],
                    ['attribute'=>'type_update', 'filter'=> (new \modules\dictionary\models\RegisterCompetitionList())->listType(), 'value'=> 'typeName',],

                    'number_update',
                    'date',
                    'time',
                ]
            ]); ?>
        </div>
    </div>
</div>
