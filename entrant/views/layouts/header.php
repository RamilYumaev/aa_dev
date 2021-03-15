<?php

use yii\helpers\Html;

/* @var $this \yii\web\View */
/* @var $content string */
?>

<header class="main-header skin-green-light">

    <?= Html::a('<span class="logo-mini">АА</span><span class="logo-lg">' . Yii::$app->name . '</span>', Yii::$app->homeUrl, ['class' => 'logo']) ?>

    <nav class="navbar navbar-static-top" role="navigation">

        <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
            <span class="sr-only">Toggle navigation</span>
        </a>
        <div class="navbar-custom-menu">
            <ul class="nav navbar-nav">
                <?php if(Yii::$app->user->can('volunteering')):?>
                    <li>
                        <?= Html::a('<span class="fa fa-users"></span>', ['/dictionary-module/volunteering/']) ?>
                    </li>
                <?php endif; ?>
                <?php if(Yii::$app->user->can('work')):?>
                <li>
                    <?= Html::a('<span class="fa fa-pencil"></span>', ['/management-user/default']) ?>
                </li>
                <li>
                    <?= Html::a('<span class="fa fa-clock-o"></span>', ['/management-user/schedule']) ?>
                </li>
                <?php endif; ?>
                <li class="dropdown user user-menu">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        <img src="/img/nophoto.png" class="user-image" alt="User Image"/>
                        <span class="hidden-xs"><?= \olympic\helpers\auth\ProfileHelper::profileFullName(Yii::$app->user->id) ?></span>
                    </a>
                    <ul class="dropdown-menu">

                        <!-- User image -->
                        <li class="user-header">
                            <img src="/img/nophoto.png" class="img-circle"
                                 alt="User Image"/>

                            <p>
                                <?= \olympic\helpers\auth\ProfileHelper::profileFullName(Yii::$app->user->id) ?>
                            </p>
                        </li>
                                <?= Html::beginForm(['/account/logout'], 'post', ['id' => 'logout'])
                                . Html::submitButton(
                                    'Выйти',
                                    ['class' => 'btn btn-default btn-flat']
                                )
                                . Html::endForm(); ?>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
    </nav>
</header>
