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
        !Yii::$app->user->isGuest ?
        ['label'=> \yii\helpers\Html::tag("span", "", ["class"=> "glyphicon glyphicon-cog"]),
            'url'=> '/sign-up/user-edit'] : ['label' => ''],
        !Yii::$app->user->isGuest ? ['label' => 'Подача документов', 'url' => ['/abiturient/anketa/step1']] : ['label' => ''],
        ['label' => 'Олимпиады/конкурсы', 'url' => ['/olympiads']],
        ['label' => 'Дни открытых дверей', 'url' => ['/dod']],
        // ['label' => 'Мастер-классы', 'url' => ['/site/master-classes']],
        Yii::$app->user->isGuest ?
            ['label' => 'Регистрация', 'url' => ['/sign-up/request']] : ['label' => ''],
        Yii::$app->user->isGuest ?
            ['label' => 'Вход', 'url' => ['/account/login']] :
            ['label' => 'Выход (' . Yii::$app->user->identity->getUsername() . ')',
                'url' => ['/account/logout'], 'linkOptions' => ['data-method' => 'post']],
    ],
    'encodeLabels' => false,

]);
NavBar::end();