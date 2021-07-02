<?php

use modules\entrant\helpers\BlockRedGreenHelper;
use yii\helpers\Html;
use yii\widgets\DetailView;
use xj\qrcode\QRcode;
use xj\qrcode\widgets\Text;

/* @var $this yii\web\View */
/* @var $phone \olympic\models\auth\Profiles */
/* @var $model frontend\search\Profile*/
/* @var $type  string */
?>
<div class="p-30 green-border">
    <h4>Данные по телефону: <?= $model->phone ?> </h4>
    <?php
    if ($phone) :?>
    <?= Html::a('Перейти в ЛК',['by-user-id', 'id'=> $phone->user_id]) ?>
        <?= DetailView::widget([
        'options' => ['class' => 'table table-bordered detail-view'],
        'model' => $phone,
        'attributes' => [
            'user.email',
            'last_name', 'first_name', 'patronymic' , 'phone',
            'passportData.series',
            'passportData.number',
            'user:boolean'
        ]
    ]) ?>

        <?= Text::widget([
            'outputDir' => '@webroot/qr',
            'outputDirWeb' => '@web/qr',
            'ecLevel' => QRcode::QR_ECLEVEL_L,
            'text' => 'https://sdo.mpgu.org/switch-user/by-user-id?id=' . $phone->user_id,
            'size' => 8,
        ]);
        ?>
    <?php else: ?>
        <p>Ничего не найдено</p>
    <?php endif; ?>
</div>
