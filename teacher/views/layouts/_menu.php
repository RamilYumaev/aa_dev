<?php
return !Yii::$app->user->isGuest ? (
array_merge(
        [['label' => 'Профиль учителя', 'url' => '/profile/edit',],
            ['label' => 'Данные об работодателе', 'url' => '/schools/index'],
         ['label' => 'Ученики/студенты', 'url' => '/user-schools/index',]]
)) : [];