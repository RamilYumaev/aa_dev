<?php

use modules\entrant\helpers\BlockRedGreenHelper;
use modules\entrant\helpers\FileHelper;
use modules\transfer\widgets\file\FileWidget;
use modules\transfer\widgets\file\FileListWidget;
use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $model modules\entrant\models\InsuranceCertificateUser */
?>
<div class="row">
    <div class="col-md-12 <?= BlockRedGreenHelper::colorBg($model) ?>">
        <div class="p-30 green-border">
            <h4>СНИЛС</h4>
            <?php if ($model): ?>
                <?= Html::a('Изменить', ['/transfer/default/insurance-certificate'], ['class' => 'btn btn-warning']) ?>
                <?= DetailView::widget([
                    'options' => ['class' => 'table table-bordered detail-view'],
                    'model' => $model,
                    'attributes' =>[
                            'number'
                    ]
                ]) ?>
            <?php else: ?>
                <?= Html::a('Добавить', ['/transfer/default/insurance-certificate'], ['class' => 'btn btn-success']) ?>
            <?php endif; ?>
        </div>
    </div>
</div>