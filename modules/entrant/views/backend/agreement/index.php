<?php
use yii\grid\ActionColumn;
use modules\entrant\helpers\DateFormatHelper;
use backend\widgets\adminlte\grid\GridView;
use modules\entrant\helpers\SelectDataHelper;
use modules\entrant\helpers\AgreementHelper;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $searchModel modules\entrant\searches\AgreementSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

/* @var $status integer */
$st= AgreementHelper::statusName($status);
$status = !is_null($st) ? " (".$st.")" : "";

$this->title = "Целевые договора". $status;;

$this->params['breadcrumbs'][] = $this->title;

?>
<div class="user-index">
    <div class="box">
        <div class="box-body">
            <?= GridView::widget([
                'dataProvider' => $dataProvider,
                'filterModel' => $searchModel,
                'columns' => [
                        ['class' => ActionColumn::class, 'controller' => 'agreement', 'template' => '{view}'],
                    'user_id',
                    [
                        'attribute' => 'user_id',
                        'filter' => SelectDataHelper::dataSearchModel($searchModel, AgreementHelper::columnAgreement('user_id',  'profile.fio'), 'user_id', 'profile.fio'),
                        'value'=> 'profile.fio'

                    ],
                    [
                        'attribute' => 'organization_id',
                        'filter' => SelectDataHelper::dataSearchModel($searchModel, AgreementHelper::columnAgreement('organization_id',  'organization.name'), 'organization_id', 'organization.name'),
                        'value'=> 'organization.name'

                    ],
                    'number',
                    'date:date',
                    [
                        'class' => \modules\entrant\searches\grid\AgreementColumn::class,
                    ],
                    [ 'header'=> "Файлы",
                        'class' => \modules\entrant\searches\grid\FileColumn::class,
                    ],
                ],
            ]); ?>
        </div>
    </div>
</div>