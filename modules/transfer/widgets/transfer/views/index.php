<?php

use modules\entrant\helpers\BlockRedGreenHelper;
use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model \modules\transfer\models\StatementTransfer
 */
/* @var $isUserSchool bool */
?>
<div class="row">
    <div class="col-md-12 <?= BlockRedGreenHelper::colorBg($model) ?>">
        <div class="p-30 green-border">
            <h4>Куда осуществляется перевод/восстановление?</h4>
                <?php if ($model) : ?>
                    <?php
                    $columns = [
                        ['label' => '',
                            'value' => $model->cg->yearConverter()[1]."".$model->cg->getFullNameCg(),],
                        ['label' =>'',
                            'value' => $model->dictClass->classFullName,],
                    ];
                    ?>
                    <?= Html::a('Изменить', ['/transfer/current-education-info'], ['class' => 'btn btn-warning']) ?>
                    <?= DetailView::widget([
                        'options' => ['class' => 'table table-bordered detail-view'],
                        'model' => $model,
                        'attributes' => $columns
                    ]) ?>
                <?php else: ?>
                    <?= Html::a('Найти', ['/transfer/current-education-info'], ['class' => 'btn btn-success']) ?>
                <?php endif; ?>
        </div>
    </div>
</div>