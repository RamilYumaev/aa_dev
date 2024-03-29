<?php

use modules\entrant\helpers\BlockRedGreenHelper;
use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $fio modules\entrant\models\FIOLatin */

?>
<div class="row">
    <div class="col-md-12 <?= BlockRedGreenHelper::colorBg($fio ? true : false) ?>">
        <div class="p-30 green-border">
            <h4>ФИО на латинском</h4>
            <?php if ($fio) : ?>
                <?php
                $columns = [
                    'surname',
                    'name',
                ];
                ?>
                <?php if ($fio['patronymic']): ?>
                    <?php array_push($columns, 'patronymic') ?>
                <?php endif; ?>
                <?= Html::a('Редактировать', ['fio-latin/index'], ['class' => 'btn btn-warning']) ?>
                <?= DetailView::widget([
                    'options' => ['class' => 'table table-bordered detail-view'],
                    'model' => $fio,
                    'attributes' => $columns
                ]) ?>
            <?php else: ?>
                <?= Html::a('Добавить', ['fio-latin/index'], ['class' => 'btn btn-success']) ?>
            <?php endif; ?>
        </div>
    </div>
</div>