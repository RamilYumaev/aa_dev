<?php
return [
    'class' => 'yii\authclient\Collection',
    'clients' => [
//                'google' => [
//                    'class' => 'yii\authclient\clients\Google',
//                    'clientId' => 'google_client_id',
//                    'clientSecret' => 'google_client_secret',
//                ],

        'yandex' => [
            'class' => 'yii\authclient\clients\Yandex',
            'clientId' => '14ccd7cc6ae04ed680e250aa2b65a369',
            'clientSecret' => 'f2ed1d137a0443529b607514ad49985f',
        ],

        'facebook' => [
            'class' => 'yii\authclient\clients\Facebook',
            'clientId' => '993150624227282',
            'clientSecret' => '062d3794e0913366d9dd9aef50bfbd4f',
            'scope' => 'email',
        ],

        'vkontakte' => [
            'class' => 'yii\authclient\clients\VKontakte',
            'clientId' => '6840071',
            'clientSecret' => 'kjKLyc2zgJB5k9pL80A9',
            'scope' => 'email',
        ]
    ]];