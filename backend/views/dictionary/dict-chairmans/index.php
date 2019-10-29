<?php

use himiklab\yii2\ajaxedgrid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Председатели';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="box box-default">
    <div class="box">
        <div class="box-body">
             <?= GridView::widget([
            'dataProvider' => $dataProvider,
            'columns' => [
            'last_name',
            'first_name',
            'patronymic',
            'position'],
                 'updateRoute' => ['dictionary/dict-chairmans/update'],
                 'deleteRoute'=> ['dictionary/dict-chairmans/delete'],
            ]) ?>
        </div>
    </div>
</div>

