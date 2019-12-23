<?php


/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

use yii\helpers\Html;

$this->title = 'Настройки электронных почт для рассылок';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-create">
    <div class="box">
        <div class="box-header">
            <?=Html::a('Добавить', ['create',], ['class'=>'btn btn-primary']) ?>
        </div>
        <div class="box-body">
            <?= \backend\widgets\adminlte\grid\GridView::widget([
                'dataProvider' => $dataProvider,
                'columns' => [
                    ['class' => \yii\grid\SerialColumn::class],
                    ['value' => function ($model) {
                       return \olympic\helpers\auth\ProfileHelper::profileFullName($model->user_id);
                    },
                        'attribute'=>'user_id'],
                    'host',
                    'username',
                   //'password',
                    'port',
                    'encryption',
                    ['value' => function (\common\auth\models\SettingEmail $model) {
                        return $model->isActivate() ? "Проверено" : Html::a('Проверить', ['activate', 'id' => $model->id],
                            ['class'=> "btn btn-success",'data-method'=>'post']);
                    }, 'format'=> 'raw'],
                    ['class' => \yii\grid\ActionColumn::class, 'template'=> "{update} {delete}"],
                ]
            ]); ?>
        </div>
    </div>
</div>
