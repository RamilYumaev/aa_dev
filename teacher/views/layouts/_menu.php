<?php
return !Yii::$app->user->isGuest ? (
array_merge(
        [
            ['label' => 'Инструкция', 'url' => '/instructions/teacher.pdf',],
            ['label' => 'Профиль учителя', 'url' => '/profile/edit',],
            ['label' => 'Данные о работодателе', 'url' => '/schools/index'],
         ['label' => 'Ученики/студенты', 'url' => '/user-schools/index',]]
)) : [];