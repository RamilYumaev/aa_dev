<?php
return !Yii::$app->user->isGuest ? (
array_merge(
        [
            ['label' => 'Профиль', 'url' => ['/profile/edit']],
            ['label' => 'Настройки', 'url' => ['/sign-up/user-edit']],
            ['label' => 'Абитуриенты', 'url' => ['/data-entrant/default/index']],
            ['label' => 'Заявления (ЗУК)', 'url' => ['/data-entrant/statement/index']],
            ['label' => 'Заявления (ЗОС)', 'url' => ['/data-entrant/statement-consent-cg/index']],
            ['label' => 'Заявления (ЗИД)', 'url' => ['/data-entrant/statement-individual-achievements/index']],
            ]

)) : [];