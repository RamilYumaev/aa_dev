<?php
use yii\grid\ActionColumn;
use modules\entrant\helpers\DateFormatHelper;
use backend\widgets\adminlte\grid\GridView;
use modules\entrant\helpers\SelectDataHelper;
use modules\entrant\helpers\StatementHelper;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $searchModel modules\entrant\searches\AgreementSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
$this->title = "Целевые договора";

$this->params['breadcrumbs'][] = $this->title;

?>
<div class="user-index">
    <div class="box">
        <div class="box-body">
            <?= GridView::widget([
                'dataProvider' => $dataProvider,
                'filterModel' => $searchModel,
                'columns' => [
                    [
                        'attribute' => 'user_id',
                        'value'=> 'profile.fio'

                    ],
                    ['class' => ActionColumn::class, 'controller' => 'agreement', 'template' => '{view}']
                ],
            ]); ?>
        </div>
    </div>
</div>