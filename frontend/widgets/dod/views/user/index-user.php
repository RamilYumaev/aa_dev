<?php

use yii\helpers\Html;

/* @var  $dod dod\models\DateDod */
/* @var  $userDod dod\models\UserDod */
$class= 'btn btn-lg btn-bd-primary mb-3 mb-md-0 mr-md-3';
use dod\helpers\UserDodHelper;
?>
<div>
    <center>
        <?php if ($dod->isTypeRemote()) : ?>
            <?= Html::a('Онлайн участие', ['dod', 'id' => $dod->id], ['class' => $class]); ?>
        <?php elseif ($dod->isTypeIntramuralLiveBroadcast()) :  ?>
            <?php if (!$userDod): ?>
                <?= Html::a('«Приду  на мероприятие»', ['user-dod/registration', 'id' => $dod->id, 'type'=> UserDodHelper::FORM_INTRAMURAL], ['class' => $class]); ?>
                <?= Html::a('«Посмотрю прямую трансляцию»', ['user-dod/registration', 'id' => $dod->id, 'type'=> UserDodHelper::FORM_LIVE_BROADCAST], ['class' => $class]); ?>
            <?php endif; ?>
        <?php elseif ($dod->isTypeRemoteEdu()) :  ?>
            <?php if (!$userDod): ?>
                <?= Html::a('Зарегистрироваться', ['user-dod/registration-on-dod-remote-user', 'id' => $dod->id], ['class' => $class]); ?>
            <?php endif; ?>
        <?php elseif ($dod->isTypeHybrid()) :  ?>
            <?php if (!$userDod): ?>
                <?= Html::a('Онлайн участие', ['dod', 'id' => $dod->id], ['class' => $class]); ?>
                <?= Html::a('Зарегистрироваться', ['user-dod/registration', 'id' => $dod->id], ['class' => $class]); ?>
            <?php endif; ?>
        <?php else: ?>
            <?php if (!$userDod): ?>
                <?= Html::a('Зарегистрироваться', ['user-dod/registration', 'id' => $dod->id], ['class' => $class]); ?>
            <?php endif; ?>
        <?php endif; ?>
        <?php if ($userDod): ?>
            <?php if ($dod->isTypeHybrid()) : ?>
                <?= Html::a('Отменить регистрацию', ['user-dod/delete', 'id' => $userDod->dod_id],
                    ['class' => $class, 'data' => ['confirm' => 'Вы действительно хотите отменить?', 'method' => 'POST']]); ?>
                <?= Html::a('Онлайн участие', ['dod', 'id' => $dod->id], ['class' => $class]); ?>
            <?php else: ?>
                <?= Html::a('Отменить регистрацию', ['user-dod/delete', 'id' => $userDod->dod_id],
                ['class' => $class, 'data' => ['confirm' => 'Вы действительно хотите отменить?', 'method' => 'POST']]); ?>
            <?php endif; ?>
        <?php endif; ?>
    </center>
</div>

