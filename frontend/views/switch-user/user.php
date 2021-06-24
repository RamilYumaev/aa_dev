<?php

use modules\entrant\helpers\BlockRedGreenHelper;
use yii\helpers\Html;
use yii\widgets\DetailView;
use xj\qrcode\QRcode;
use xj\qrcode\widgets\Text;
/* @var $this yii\web\View */
/* @var $user common\auth\models\User*/
/* @var $model frontend\search\Profile*/
/* @var $type  string */
?>
<div class="p-30 green-border">
    <h4>Данные по email: <?= $model->email ?> </h4>
    <?php
    if ($user) :?>
        <?= Html::a('Перейти в ЛК',['by-user-id', 'id'=> $user->id]) ?>
        <?= DetailView::widget([
        'options' => ['class' => 'table table-bordered detail-view'],
        'model' => $user,
        'attributes' => [
            'email',
            'profiles.last_name', 'profiles.first_name', 'profiles.patronymic' , 'profiles.phone',
            'status:boolean'
        ]
    ]) ?>
        <?= Text::widget([
            'outputDir' => '@webroot/qr',
            'outputDirWeb' => '@web/qr',
            'ecLevel' => QRcode::QR_ECLEVEL_L,
            'text' => 'https://sdo.mpgu.org/switch-user/by-user-id?id=' . $user->id,
            'size' => 8,
        ]);
        ?>
    <?php else: ?>
        <p>Ничего не найдено</p>
    <?php endif; ?>
</div>