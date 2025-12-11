<?php

use dictionary\helpers\DictCompetitiveGroupHelper;
use yii\grid\ActionColumn;
use modules\entrant\helpers\DateFormatHelper;
use backend\widgets\adminlte\grid\GridView;
use modules\entrant\helpers\SelectDataHelper;
use modules\entrant\helpers\StatementHelper;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $searchModel modules\entrant\searches\StatementSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $type integer */
$types = (new \modules\transfer\models\TransferMpgu())->listType() ;
$status = $type && key_exists($type, $types) ? " (".$types[$type].")" : "";

$this->title = "Студенты ". $status;

$this->params['breadcrumbs'][] = ['label' => 'Перевод и восстановление', 'url' => ['default/index']];
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="user-index">
    <div class="box">
        <div class="box-body table-responsive">
            <?= GridView::widget([
                'dataProvider' => $dataProvider,
                'filterModel' => $searchModel,
                'columns' => [
                    [
                            'attribute' => 'user_id',
                            'filter' => SelectDataHelper::dataSearchModel($searchModel, \modules\transfer\models\TransferMpgu::find()
                                ->joinWith('profile')->select(['CONCAT(last_name, \' \', first_name, \' \', patronymic)'])->indexBy('user_id')->column(),
                                'user_id', 'profile.fio'),
                            'value'=> 'profile.fio'

                    ],[
                        'attribute' => 'type',
                        'filter' => $types,
                        'value'=> function(\modules\transfer\models\TransferMpgu $model) {
                            return $model->typeName();
                        }
                    ],
                    'number',
                    'year',
                    'data_order',
                    ['class' => ActionColumn::class, 'controller' => 'profiles', 'template' => '{view}']
                ],
            ]); ?>
        </div>
    </div>
</div>

