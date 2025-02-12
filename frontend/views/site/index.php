<?php

use modules\exam\helpers\ExamCgUserHelper;
use yii\helpers\Html;

$this->title = 'Личный кабинет поступающего в МПГУ';
?>

<?php if (!Yii::$app->user->isGuest && ExamCgUserHelper::examExists(Yii::$app->user->identity->getId())) : ?>
    <div class="row mt-30">
        <div class="col-md-2 col-md-offset-1" align="center">
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

        <!--                <div class="col-md-2" align="center">-->
        <!--                    --><?php //if (!Yii::$app->user->isGuest) {
        //                        echo Html::a(Html::img('@web/img/cabinet/dod.png')
        //                            . '<br/>Записаться на Дни открытых дверей', '/dod');
        //                    } ?>
        <!---->
        <!--                </div>-->

        <div class="col-md-2" align="center">
            <?php if (!Yii::$app->user->isGuest) {
                echo Html::a(Html::img('@web/img/cabinet/online.png')
                    . '<br/>Подача документов', '/abiturient/anketa/step1');
            } ?>

        </div>

        <div class="col-md-2" align="center">
            <?php if (!Yii::$app->user->isGuest && ExamCgUserHelper::examExists(Yii::$app->user->identity->getId())) {
                echo Html::a(Html::img('@web/img/cabinet/exam.png')
                    . '<br/>Экзамены', '/exam');
            } ?>

        </div>

        <div class="col-md-2" align="center">
            <?php if (!Yii::$app->user->isGuest) {
                echo Html::a(Html::img('@web/img/cabinet/university.png')
                    . '<br/>Перевод и восстановление', '/transfer/default/fix');
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

<?php else : ?>

    <div class="row mt-30">
        <div class="col-md-2 col-md-offset-2" align="center">
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

        <div class="col-md-2" align="center">
            <?php if (!Yii::$app->user->isGuest) {
                echo Html::a(Html::img('@web/img/cabinet/university.png')
                    . '<br/>Перевод и восстановление', '/transfer/default/fix');
            } ?>

        </div>
    </div>

<?php endif; ?>

<div class="row mt-50">
    <div class="col-md-10 col-md-offset-1">
        <?php if (!Yii::$app->user->isGuest) : ?>
            <?= \modules\literature\widgets\ButtonWidget::widget(['userId' => Yii::$app->user->identity->getId()]) ?>
            <?= \modules\entrant\widgets\information\InfodaWidget::widget(['userId' => Yii::$app->user->identity->getId()]); ?>
            <?= \modules\entrant\widgets\statement\StatementIndexWidget::widget(['userId' => Yii::$app->user->identity->getId()]); ?>
            <?= \modules\entrant\widgets\statement\StatementCgFrontendConsentWidget::widget(['userId' => Yii::$app->user->identity->getId()]); ?>
            <?= \modules\entrant\widgets\statement\StatementIaFrontendWidget::widget(['userId' => Yii::$app->user->identity->getId()]); ?>
            <?= \modules\entrant\widgets\statement\StatementCgContractFrontendWidget::widget(['userId' => Yii::$app->user->identity->getId()]); ?>
            <?= \modules\entrant\widgets\statement\StatementRecordAndRejectionWidget::widget(['userId' => Yii::$app->user->identity->getId()]); ?>
            <?= \modules\transfer\widgets\transfer\StatementTransferFrontendWidget::widget(['userId' => Yii::$app->user->identity->getId()]); ?>
            <?= \frontend\widgets\olympic\UserOlympicListWidget::widget(); ?>
        <?php endif; ?>
    </div>
</div>


<?php if (Yii::$app->user->isGuest): ?>
<div class="jumbotron">
    <?php if (\Yii::$app->request->get('time')):; ?>
        <p>Серверное время: <?= \date("Y-m-d G:i:s") ?></p>
    <?php endif; ?>
    <h1>Добро пожаловать в Личный кабинет<br/> поступающего в МПГУ!</h1>
    <h4 align="center">
        <a href="/instructions/instruction.pdf" download>
            Как подать документы онлайн (читать инструкцию)>></a></h4>
    <p></p>
    <p align="center">С помощью Личного кабинета Вы можете подать документы в МПГУ для поступления на программы <b>среднего профессионального образования</b>, а также для <b>перевода и/или восстановления</b> на программы среднего профессионального образования и высшего образования (программам бакалавриата и программам магистратуры).
        Для начала пользования сервисами поступающего необходимо создать Личный кабинет.</p>

    <a class="btn btn-primary btn-lg mpgu-btn" href="/olympiads" role="button" style="margin-left: 4px">Олимпиады МПГУ</a>
    <a class="btn btn-primary btn-lg mpgu-btn" href="/sign-up/request" role="button">Создать Личный
        кабинет</a>

    <?php endif ?>

</div>

