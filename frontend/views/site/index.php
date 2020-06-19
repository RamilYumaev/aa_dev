<?php

use yii\helpers\Html;

$this->title = 'Личный кабинет поступающего в МПГУ';
?>


<div class="row mt-30">
    <div class="col-md-2 col-md-offset-3" align="center">
        <?php if (!Yii::$app->user->isGuest) {
            echo Html::a(Html::img('@web/img/cabinet/profile.png') . '<br/>Ваш профиль', '/profile/edit');
        } ?>

    </div>

    <div class="col-md-2" align="center">
        <?php if (!Yii::$app->user->isGuest) {
            echo Html::a(Html::img('@web/img/cabinet/school.png')
                . '<br/>Ваша учебная организация', '/schools');
        } ?>

    </div>


<!--    <div class="col-md-2" align="center">-->
<!--        --><?php //if (!Yii::$app->user->isGuest) {
//            Html::a(Html::img('@web/img/cabinet/olympiads.png')
//                . '<br/>Записаться на олимпиады', '/olympiads');
//        } ?>

        <!--        </div>-->

        <!--        <div class="col-md-2" align="center">-->
        <!--            --><?php //if (!Yii::$app->user->isGuest) {
        //                echo Html::a(Html::img('@web/img/cabinet/dod.png')
        //                    . '<br/>Записаться на Дни открытых дверей', '/dod');
        //            } ?>
        <!---->
        <!--        </div>-->

            <div class="col-md-2" align="center">
                <?php if (!Yii::$app->user->isGuest) {
                    echo Html::a(Html::img('@web/img/cabinet/online.png')
                        . '<br/>Подача документов', '/abiturient/anketa/step1');
                } ?>

            </div>


        <!--        <div class="col-md-2" align="center">-->
        <!--            --><?php //if (!Yii::$app->user->isGuest) {
        //                echo Html::a(Html::img('@web/img/cabinet/master-class.png')
        //                    . '<br/>Записаться на мастер-классы', '/master-classes');
        //            } ?>
        <!---->
        <!--        </div>-->

        <!--        <div class="col-md-2" align="center">-->
        <!--            --><?php //if (!Yii::$app->user->isGuest) {
        //                echo Html::a(Html::img('@web/img/cabinet/bak_form.png')
        //                    . '<br/>Выбрать образовательную программу бакалавриата', '/external/bak-programs');
        //            } ?>
        <!---->
        <!--        </div>-->

        <!--        <div class="col-md-2" align="center">-->
        <!--            --><?php //if (!Yii::$app->user->isGuest) {
        //                echo Html::a(Html::img('@web/img/cabinet/mag_form.png')
        //                    . '<br/>Выбрать образовательную программу магистратуры', '/external/mag-programs');
        //            } ?>
        <!---->
        <!--        </div>-->

    </div>

    <!--<div class="row mt-50">-->
    <!--    <div class="col-md-2 col-md-offset-4">-->
    <!--        --><?php //if (Yii::$app->user->can('manager')) {
    //            echo Html::a(Html::img('@web/img/cabinet/docs.png')
    //                . '<br/>Документы приемной комиссии', 'site/documents');
    //        } ?>
    <!--    </div>-->
    <!--    <div class="col-md-2">-->
    <!--        --><?php //if (Yii::$app->user->can('manager')) {
    //            echo Html::a(Html::img('@web/img/cabinet/links.png')
    //                . '<br/>Ссылки на сторонние ресурсы', 'links');
    //        } ?>
    <!--    </div>-->
    <!--</div>-->

    <div class="row mt-50">
        <div class="col-md-10 col-md-offset-1">
            <?php if (!Yii::$app->user->isGuest) : ?>
                <?= \modules\entrant\widgets\statement\StatementIndexWidget::widget(['userId' => Yii::$app->user->identity->getId()]); ?>
                <?= \modules\entrant\widgets\statement\StatementCgFrontendConsentWidget::widget(['userId' => Yii::$app->user->identity->getId()]); ?>
                <?= \modules\entrant\widgets\statement\StatementIaFrontendWidget::widget(['userId' => Yii::$app->user->identity->getId()]); ?>
                <?= \modules\entrant\widgets\statement\StatementCgContractFrontendWidget::widget(['userId' => Yii::$app->user->identity->getId()]); ?>
                <?= \frontend\widgets\olympic\UserOlympicListWidget::widget(); ?>
            <?php endif; ?>
        </div>
    </div>


    <?php if (Yii::$app->user->isGuest): ?>
    <div class="jumbotron">
        <?php if (\Yii::$app->request->get('time')): ;?>
        <p>Серверное время: <?= \date("Y-m-d G:i:s") ?></p>
        <?php endif;?>
        <h1>Добро пожаловать в Личный кабинет<br/> поступающего в МПГУ!</h1>
        <h4 align="center">
            <a href="https://docs.google.com/document/d/1ziiGMWfpqqBbdiOze-HrHgOmZHCdDqyI8g9KZBaZScU/edit?usp=sharing">
                Как подать документы онлайн (читать инструкцию)>></a></h4>
        <iframe width="560" height="315" src="https://www.youtube.com/embed/eWic-dhAr6Q?controls=0" frameborder="0"
                allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
        <p align="center">С помощью Личного кабинета Вы можете подать докуенты в МПГУ.
       Для начала пользования сервисами поступающего необходимо завести личный кабинет.</p>

        <a class="btn btn-primary btn-lg mpgu-btn" href="/sign-up/request" role="button">завести Личный
            кабинет</a>

        <?php endif ?>

    </div>

    <div class="container">

    </div>



