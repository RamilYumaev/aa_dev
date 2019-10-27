<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use dictionary\helpers\CategoryDocHelper;

/* @var $this yii\web\View */
/* @var $catDoc dictionary\models\CategoryDoc */

$this->title = $catDoc->name;
$this->params['breadcrumbs'][] = ['label' => 'Категории документов', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>


<div class="catDoc-view">
    <p>
        <?= Html::a('Обновить', ['update', 'id' => $catDoc->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Удалить', ['delete', 'id' => $catDoc->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Вы уверены, что хотите удалить?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <div class="box">
        <div class="box-body">
            <?= DetailView::widget([
                'model' => $catDoc,
                'attributes' => [
                    'id',
                    'name',
                    [
                        'attribute' => 'type_id',
                        'value' => CategoryDocHelper::categoryDocTypeName($catDoc->type_id),
                        'format' => 'raw',
                    ],
                ],
            ]) ?>
        </div>
    </div>
</div>
