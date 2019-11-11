<?php

use yii\helpers\Html;
/* @var  $dod_id int */
/* @var  $userDod dod\models\UserDod */
?>
<?php if(!$userDod): ?>
    <?= Html::a('Зарегистрироваться',
        ['user-dod/registration', 'id' => $dod_id],
        ['class' => 'btn btn-lg btn-bd-primary mb-3 mb-md-0 mr-md-3']); ?>
<?php else: ?>
    <?= Html::a('Отменить регистрацию', ['user-dod/delete', 'id' => $userDod->dod_id],
        ['class' => 'btn btn-lg btn-bd-primary mb-3 mb-md-0 mr-md-3',
            'data' => ['confirm' => 'Вы действительно хотите отменить?', 'method' => 'POST']]); ?>
<?php endif; ?>

