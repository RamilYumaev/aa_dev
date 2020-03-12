<?php

use yii\helpers\Html;

/* @var  $dod dod\models\DateDod */
/* @var  $userDod dod\models\UserDod */
$class= 'btn btn-lg btn-bd-primary mb-3 mb-md-0 mr-md-3';
?>
<div>
    <center>
        <?php if ($dod->isTypeRemote()) : ?>
            <?= Html::a('Онлайн участие', ['dod', 'id' => $dod->id], ['class' => $class]); ?>
        <?php else: ?>
            <?php if (!$userDod): ?>
                <?= Html::a('Зарегистрироваться',
                    ['user-dod/registration', 'id' => $dod->id],
                    ['class' => $class]); ?>
                <?php else: ?>
                <?= Html::a('Отменить регистрацию', ['user-dod/delete', 'id' => $userDod->dod_id],
                    ['class' => $class, 'data' => ['confirm' => 'Вы действительно хотите отменить?', 'method' => 'POST']]); ?>
            <?php endif; ?>
        <?php endif; ?>
    </center>
</div>

