<?php

use backend\widgets\adminlte\grid\GridView;

/* @var $this yii\web\View */
/* @var $provider yii\data\ArrayDataProvider */
/* @var $result array */

$this->title = "Справочники суперсервиса";
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-index">
    <div class="box">
        <div class="box-body table-responsive">
            <?php foreach($result as $value) : ?>
                <h4> <?= \yii\helpers\Html::a($value['text'],['tables', 'name'=> $value['name']]) ?> </h4>
            <?php endforeach; ?>
        </div>
    </div>
</div>

