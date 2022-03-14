<?php

use backend\widgets\grid\RoleColumn;

use yii\grid\ActionColumn;
use yii\helpers\Html;
use kartik\date\DatePicker;
use common\auth\helpers\UserHelper;
use common\auth\models\User;
use backend\widgets\adminlte\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel olympic\forms\auth\search\UserSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Пользователи';
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="user-index">
    <div class="box">
        <div class="box-body">
            <?= GridView::widget([
                'dataProvider' => $dataProvider,
                'filterModel' => $searchModel,
                'columns' => [
                    'id',
                    [
                        'attribute' => 'username',
                        'value' => function (User $model) {
                            return Html::a(Html::encode($model->username), ['view', 'id' => $model->id]);
                        },
                        'format' => 'raw',
                    ],
                    'email:email',
                    [
                        'attribute' => 'role',
                        'class' => RoleColumn::class,
                        'filter' => $searchModel->rolesList(),
                    ],
                    [
                        'attribute' => 'status',
                        'filter' => UserHelper::statusList(),
                        'value' => function (User $model) {
                            return UserHelper::statusLabel($model->status);
                        },
                        'format' => 'raw',
                    ],
                    ['class' => ActionColumn::class],
                ],
            ]); ?>
        </div>
    </div>
</div>
