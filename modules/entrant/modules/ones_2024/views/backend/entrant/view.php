<?php

use entrant\assets\modal\ModalAsset;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model \modules\entrant\modules\ones_2024\model\EntrantSS */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $searchModel \modules\entrant\modules\ones_2024\forms\search\EntrantAppSearch */

$this->title = "Абитуриент. Просмотр. " .$model->fio;
$this->params['breadcrumbs'][] = ['label' => 'Абтуриенты', 'url' => ['entrant/index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div>
    <div class="box">
        <div class="box-body">
            <?= \yii\widgets\DetailView::widget([
                'model' => $model,
                'attributes' => [
                    'quid',
                    "fio",
                    "snils",
                    "id_ss",
                    "sex",
                    'nationality',
                    'type_doc',
                    'series',
                    'number',
                    'date_of_issue',
                    'authority',
                    'division_code',
                    'date_of_birth',
                    'place_of_birth',
                    'email',
                    'phone',
                    'is_hostel:boolean'
                ],
            ]) ?>
        </div>
    </div>
</div>
<div>
    <div class="box">
        <div class="box-header">
            <h3>Заявления</h3>
        </div>
        <div class="box-body">
            <div class="box-body">
                <?= \himiklab\yii2\ajaxedgrid\GridView::widget([
                    'dataProvider' => new \yii\data\ActiveDataProvider(['query' =>  $model->getEntrantApps()]),
                    'addButtons' => [],
                    'columns' => [
                        'actual',
                        'priority_vuz',
                        'priority_ss',
                        'cg.name',
                        'cg.id',
                        'status',
                        'source',
                        'is_el_original:boolean',
                        'is_paper_original:boolean',
                    ],
                    'actionColumnTemplate' => '',
                ]) ?>
            </div>
        </div>
    </div>
</div>
