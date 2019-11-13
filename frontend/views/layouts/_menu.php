<?php
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;

NavBar::begin([
    'innerContainerOptions' => ['class' => 'container-fluid'],
    'options' => array_merge(
        ['class' => 'navbar-inverse navbar-fixed-top mb-30'],
        $_SERVER['HTTP_HOST'] === 'sdo.mpgu.org' ? ['style' => 'background-color: #204462'] :
            ($_SERVER['HTTP_HOST'] === 'aa:8080' ? ['style' => 'background-color: #605ca8'] : ['style' => 'background-color: #24a22d'])),

]);

echo Nav::widget([
    'options' => ['class' => 'navbar-nav navbar-right pr-30'],
    'items' => [
        ['label' => 'Олимпиады/конкурсы', 'url' => ['/olympiads']],
        ['label' => 'Дни открытых дверей', 'url' => ['/dod']],
        // ['label' => 'Мастер-классы', 'url' => ['/site/master-classes']],
        Yii::$app->user->isGuest ?
            ['label' => 'Регистрация', 'url' => ['/auth/signup/request']] : ['label' => ''],
        Yii::$app->user->isGuest ?
            ['label' => 'Вход', 'url' => ['/auth/auth/login']] :
            ['label' => 'Выход (' . Yii::$app->user->identity->getUsername() . ')',
                'url' => ['/auth/auth/logout'], 'linkOptions' => ['data-method' => 'post']],
    ]

]);
NavBar::end();