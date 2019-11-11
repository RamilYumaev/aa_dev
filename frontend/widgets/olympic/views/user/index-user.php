<?php

use yii\helpers\Html;
/* @var  $dod_id int */
/* @var  $userDod dod\models\UserDod */
?>
<?php if(!$userDod): ?>
    <?= Html::a('Записаться', ['user-olympic/registration', 'id' => $currentOlimp->id],
        ['class' => 'btn btn-primary btn-lg']) ?>
<?php else: ?>
    <?= Html::a('Отменить запись',
        ['user-olympic/delete-on-olimpiads', 'id' => $currentOlimp->id],
        ['class' => 'btn btn-primary btn-lg',
            'data' => ['confirm' => 'Вы действительно хотите отменить запись ?', 'method' => 'POST']]); ?>
<?php endif; ?>

