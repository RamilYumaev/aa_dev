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
            'scope' => 'email',
        ],

//        'facebook' => [
//            'class' => 'yii\authclient\clients\Facebook',
//            'clientId' => '502733187338172',
//            'clientSecret' => '404861ebbcc6dbd75e92a794cd275260',
//            'scope' => 'email',
//        ],

        'vkontakte' => [
            'class' => 'yii\authclient\clients\VKontakte',
            'clientId' => '6774734',
            'clientSecret' => 'DnZyVThgj3x3bLbhdMUh',
            'scope' => 'email',
        ]
    ]];