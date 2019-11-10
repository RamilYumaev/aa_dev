<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use dictionary\helpers\CategoryDocHelper;

/* @var $this yii\web\View */
/* @var $competitiveGroup dictionary\models\DictCompetitiveGroup */


$this->title = "Просмотр";
$this->params['breadcrumbs'][] = ['label' => 'Конкурсные группы', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>


<div>
    <p>
        <?= Html::a('Обновить', ['update', 'id' => $competitiveGroup->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Удалить', ['delete', 'id' => $competitiveGroup->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Вы уверены, что хотите удалить?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= \backend\widgets\dictionary\DateDocWidget::widget(['competitive_group_id'=> $competitiveGroup->id]) ?>

</div>
