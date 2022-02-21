<?php
use yii\grid\ActionColumn;
use modules\entrant\helpers\DateFormatHelper;
use backend\widgets\adminlte\grid\GridView;
use modules\entrant\helpers\SelectDataHelper;
use modules\entrant\helpers\AgreementHelper;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $searchModel modules\entrant\searches\admin\AnketaSearch*/
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = "Анкеты";
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="user-index">
    <div class="box">
        <div class="box-body">
            <?= GridView::widget([
                'dataProvider' => $dataProvider,
                'filterModel' => $searchModel,
                'columns' => [
                        ['class' => ActionColumn::class, 'controller' => 'anketa', 'template' => '{update}'],
                    'user_id',
                    [
                        'attribute' => 'surname',
                        'header' => $searchModel->getAttributeLabel('surname'),
                        'value'=> 'profile.last_name'
                    ],
                    [
                        'attribute' => 'name',
                        'header' => $searchModel->getAttributeLabel('name'),
                        'value'=> 'profile.first_name'
                    ],
                    [
                        'attribute' => 'patronymic',
                        'header' => $searchModel->getAttributeLabel('patronymic'),
                        'value'=> 'profile.patronymic'
                    ],
                    [
                        'attribute' => 'phone',
                        'header' => $searchModel->getAttributeLabel('phone'),
                        'value'=> 'profile.phone'
                    ],
                    [
                        'attribute' => 'email',
                        'value'=> 'user.email'
                    ],
                ],
            ]); ?>
        </div>
    </div>
</div>