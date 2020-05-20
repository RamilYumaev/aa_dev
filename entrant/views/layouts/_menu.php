<?php
return !Yii::$app->user->isGuest ? (
array_merge(
        [
            ['label' => 'Профиль', 'url' => ['/profile/edit']],
            ['label' => 'Настройки', 'url' => ['/sign-up/user-edit']],
            ['label' => 'Абитуриенты', 'url' => ['/data-entrant/default/index']]
            ]

)) : [];