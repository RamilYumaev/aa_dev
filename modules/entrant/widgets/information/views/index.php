<?php

use modules\entrant\helpers\BlockRedGreenHelper;
use yii\helpers\Html;
use yii\widgets\DetailView;
use dictionary\helpers\DictCompetitiveGroupHelper;

/* @var $this yii\web\View */
/* @var $additional_information modules\entrant\models\AdditionalInformation */
/* @var $addressMoscow \modules\entrant\models\Address */

?>
<div class="row">
    <div class="col-md-12 <?= BlockRedGreenHelper::colorBg($additional_information ? true : false) ?>">
        <div class="p-30 green-border">
            <h4>Дополнительная информация</h4>
            <p> <span class="badge bg-red-light fs-15">Необходимо указать номер СНИЛС при наличии</span></p>
            <?php if ($additional_information) : ?>
                <?php
                $columns = [
                    'resource',
                    'insuranceCertificate.number',
                    'voz',
                    'mpguTraining',
                ];
                ?>
                <?php if (DictCompetitiveGroupHelper::formOchExistsUser($additional_information->user_id)): ?>
                    <?php if (is_null($addressMoscow) || ($addressMoscow && !$addressMoscow->isMoscow())): ?>
                    <?php array_push($columns, 'hostel') ?>
                <?php endif; ?>
                <?php endif; ?>
                <?php if(DictCompetitiveGroupHelper::eduSpoExistsUser($additional_information->user_id)): ?>
                    <?php if(!$additional_information->mark_spo): ?>
                        <p class="bg-danger m-10">
                            Необходимо ввести средний балл аттестата
                        </p>
                    <?php endif; ?>
                        <?php array_push($columns, 'mark_spo') ?>
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