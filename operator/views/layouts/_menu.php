<?php
return !Yii::$app->user->isGuest ? (
array_merge(
        [['label' => 'Вебинары', 'url' => '/site/web-conference',]]
)) : [];