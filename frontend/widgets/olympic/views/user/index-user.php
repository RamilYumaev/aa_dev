<?php

use yii\helpers\Html;
/* @var $olympic  olympic\models\OlimpicList */
/* @var  $userOlympic olympic\models\UserOlimpiads*/
?>
<?php if(!$userOlympic): ?>
    <?= Html::a('Записаться', ['user-olympic/registration', 'id' => $olympic->id, 'home' => $olympic->olimpic_id ],
        ['class' => 'btn btn-primary btn-lg']) ?>
<?php else: ?>
    <?= Html::a('Отменить запись', ['user-olympic/delete', 'id' => $olympic->id, 'home' => $olympic->olimpic_id],
        ['class' => 'btn btn-primary btn-lg',
            'data' => ['confirm' => 'Вы действительно хотите отменить запись ?', 'method' => 'POST']]); ?>
<?php endif; ?>

