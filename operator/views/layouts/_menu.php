<?php
return !Yii::$app->user->isGuest ? (
array_merge(
        [['label' => 'Вебинары', 'url' => '/site/web-conference',]],
         ['label' => 'Профиль учителя', 'url' => '/profile/edit',],
        [['label' => 'Сканер МПГУ', 'url' => 'https://yadi.sk/d/cHt2QjjZq_xnrw',]]
)) : [];