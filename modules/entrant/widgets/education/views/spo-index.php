<?php

use modules\entrant\helpers\BlockRedGreenHelper;
use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model modules\entrant\models\AverageScopeSpo */

$isData = $model ? true : false;
?>
<div class="row">
    <div class="col-md-12 <?= BlockRedGreenHelper::colorBg($isData) ?>">
        <div class="p-30 green-border">
        <h4>Средний балл аттестата </h4>
            <?php if ($model) : ?>
                <?= Html::a('Редактировать', ['average-scope-spo/index'], ['class' => 'btn btn-warning']) ?>
                <?= DetailView::widget([
                    'options' => ['class' => 'table table-bordered detail-view'],
                    'model' => $model,
                    'attributes' => ['number_of_threes', 'number_of_fours', 'number_of_fives', 'average']
                ]) ?>
            <?php else: ?>
                <?= Html::a('Добавить', ['average-scope-spo/index'], ['class' => 'btn btn-success']) ?>
            <?php endif; ?>
        </div>
    </div>
</div>