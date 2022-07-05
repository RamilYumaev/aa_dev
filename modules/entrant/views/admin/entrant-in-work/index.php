<?php

/* @var $this yii\web\View */
/* @var $searchModel modules\entrant\searches\admin\EntrantInWorkSearch */

/* @var $dataProvider yii\data\ActiveDataProvider */

use backend\widgets\adminlte\grid\GridView;
use modules\entrant\helpers\SelectDataHelper;
use yii\grid\ActionColumn;
use \modules\entrant\helpers\EntrantInWorkHelper;
use yii\helpers\Html;

$this->title = "Удаление атрибута \"Взято в работу\"";
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="user-index">
    <div class="box">
        <div class="box-body">
            <?= GridView::widget([
                'dataProvider' => $dataProvider,
                'filterModel' => $searchModel,
                'columns' => [
                    ['class' => \yii\grid\SerialColumn::class],
                    [
                        'attribute' => 'user_id',
                        'label'=> 'Абитуриент',
                        'value' => function (\modules\entrant\models\EntrantInWork $entrantInWork) {
                            return $entrantInWork->profile->fio;
                        }
                    ],
                    [
                        'attribute' => 'job_entrant_id',
                        'label'=> 'Сотрудник',
                        'filter' => SelectDataHelper::dataSearchModel($searchModel, EntrantInWorkHelper::listStaff(), 'job_entrant_id', 'job_entrant_id'),
                        'value' => function (\modules\entrant\models\EntrantInWork $entrantInWork) {
                            return $entrantInWork->jobEntrant->profileUser->fio;
                        }
                    ],
                    [
                        'header'=> 'Действия',
                        'value'=> function($model){
                            $url = Html::a('Удалить', ['delete', 'id'=> $model->id], [
                                'class' => 'btn btn-danger', 'data'=> ['method'=> 'post', 'confirm' => 'Вы уверены, что хотите удалить запись?']]);
                            return $url;
                        },
                        'format' => 'raw',
                    ],
                ],
            ]); ?>
        </div>
    </div>
</div>
