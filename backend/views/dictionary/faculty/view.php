<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $page common\models\dictionary\Faculty */

$this->title = $faculty->full_name;
$this->params['breadcrumbs'][] = ['label' => 'Faculty', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="faculty-view">
    <p>
        <?= Html::a('Обновить', ['update', 'id' => $faculty->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Удалить', ['delete', 'id' => $faculty->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <div class="box">
        <div class="box-body">
            <?= DetailView::widget([
                'model' => $faculty,
                'attributes' => [
                    'id',
                    'full_name',
                ],
            ]) ?>
        </div>
    </div>
</div>
