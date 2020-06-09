<?php

use yii\grid\ActionColumn;
use modules\entrant\helpers\DateFormatHelper;
use backend\widgets\adminlte\grid\GridView;
use modules\entrant\helpers\SelectDataHelper;
use modules\entrant\helpers\StatementHelper;
use yii\helpers\Html;
use yii\widgets\ListView;

/* @var $this yii\web\View */
/* @var $searchModel modules\entrant\searches\StatementSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $status integer */

$this->title = "Заявления об участии в конкурсе (Новые)" ;
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="user-index">
    <div class="box">
        <div class="box-body">
             <?= ListView::widget([
            'dataProvider' => $dataProvider,
            'itemView' => '_list',
            ]) ?>

        </div>
    </div>
</div>

