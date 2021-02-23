<?php
use yii\grid\ActionColumn;
use backend\widgets\adminlte\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel modules\entrant\searches\StatementSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $status integer */
$this->title = "Конкурсые группы. Результаты экзаменов";

$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-index">
    <div class="box">
        <div class="box-body table-responsive">
            <?= GridView::widget([
                'dataProvider' => $dataProvider,
                'columns' => [
                        'fullNameB',
                        ['value'=> function(\dictionary\models\DictCompetitiveGroup $model) {
                           return $model->getAisOrderTransfer()->count();
                        }],
                    ['class' => ActionColumn::class, 'controller' => 'result-exam', 'template' => '{view}']
                ],
            ]); ?>
        </div>
    </div>
</div>

