<?php
return !Yii::$app->user->isGuest ? (
array_merge(
        [['label' => 'Олимпиады/конкурсы', 'url' => '#',
            'items' => array_merge([
                ['label' => 'Перечень ', 'url' => '/olympic/olympic'],
      //          ['label' => 'Группы вопросов', 'url' => '/testing/test-group'],
            ])]]
)) : [];