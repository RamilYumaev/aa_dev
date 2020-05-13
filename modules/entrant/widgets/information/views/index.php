<?php

use modules\entrant\helpers\BlockRedGreenHelper;
use yii\helpers\Html;
use yii\widgets\DetailView;
use dictionary\helpers\DictCompetitiveGroupHelper;

/* @var $this yii\web\View */
/* @var $additional_information modules\entrant\models\AdditionalInformation */

?>
<div class="row">
    <div class="col-md-12 <?= BlockRedGreenHelper::colorBg($additional_information ? true : false) ?>">
        <div class="p-30 green-border">
            <h4>Дополнительная информация</h4>
            <?php if ($additional_information) : ?>
                <?php
                $columns = [
                    'resource',
                    'voz',
                ];
                ?>
                <?php if (DictCompetitiveGroupHelper::formOchExistsUser(Yii::$app->user->identity->getId())): ?>
                    <?php array_push($columns, 'hostel') ?>
                <?php endif; ?>
                <?= Html::a('Редактировать', ['additional-information/index'], ['class' => 'btn btn-warning']) ?>
                <?= DetailView::widget([
                    'options' => ['class' => 'table table-bordered detail-view'],
                    'model' => $additional_information,
                    'attributes' => $columns
                ]) ?>
            <?php else: ?>
                <?= Html::a('Добавить информацию', ['additional-information/index'], ['class' => 'btn btn-success']) ?>
            <?php endif; ?>
        </div>
    </div>
</div>