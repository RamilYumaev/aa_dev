<?php

use yii\helpers\Html;


$this->title = 'Личный кабинет поступающего в МПГУ';
?>


<div class="row mt-30">
    <div class="col-md-2" align="center">
        <?php if (!Yii::$app->user->isGuest) {
            echo Html::a(Html::img('@web/img/cabinet/profile.png') . '<br/>Ваш профиль', 'profile');
        } ?>

    </div>

    <?php if (!Yii::$app->user->can('olymp_operator')) : ?>

        <div class="col-md-2" align="center">
            <?php if (!Yii::$app->user->isGuest) {
                echo Html::a(Html::img('@web/img/cabinet/school.png')
                    . '<br/>Ваша учебная организация', 'add-educational-org');
            } ?>

        </div>

        <div class="col-md-2" align="center">
            <?php if (!Yii::$app->user->isGuest) {
                echo Html::a(Html::img('@web/img/cabinet/olympiads.png')
                    . '<br/>Записаться на олимпиады', 'olympiads');
            } ?>

        </div>

        <div class="col-md-2" align="center">
            <?php if (!Yii::$app->user->isGuest) {
                echo Html::a(Html::img('@web/img/cabinet/dod.png')
                    . '<br/>Записаться на Дни открытых дверей', 'dod');
            } ?>

        </div>


        <div class="col-md-2" align="center">
            <?php if (!Yii::$app->user->isGuest) {
                echo Html::a(Html::img('@web/img/cabinet/master-class.png')
                    . '<br/>Записаться на мастер-классы', 'master-classes');
            } ?>

        </div>

        <div class="col-md-2" align="center">
            <?php if (!Yii::$app->user->isGuest) {
                echo Html::a(Html::img('@web/img/cabinet/bak_form.png')
                    . '<br/>Выбрать образовательную программу бакалавриата', '/external/bak-programs');
            } ?>

        </div>

        <div class="col-md-2" align="center">
            <?php if (!Yii::$app->user->isGuest) {
                echo Html::a(Html::img('@web/img/cabinet/mag_form.png')
                    . '<br/>Выбрать образовательную программу магистратуры', '/external/mag-programs');
            } ?>

        </div>

    <?php endif; ?>

</div>

<div class="row mt-50">
    <div class="col-md-2 col-md-offset-4">
        <?php if (Yii::$app->user->can('manager')) {
            echo Html::a(Html::img('@web/img/cabinet/docs.png')
                . '<br/>Документы приемной комиссии', 'site/documents');
        } ?>
    </div>
    <div class="col-md-2">
        <?php if (Yii::$app->user->can('manager')) {
            echo Html::a(Html::img('@web/img/cabinet/links.png')
                . '<br/>Ссылки на сторонние ресурсы', 'links');
        } ?>
    </div>
</div>


<?php if (Yii::$app->user->isGuest): ?>
<div class="jumbotron">
    <h1>Добро пожаловать в Личный кабинет<br/> поступающего в МПГУ!</h1>
    <p align="justify">С помощью Личного кабинета Вы можете зарегистрироваться на День открытых дверей, принять
        участие
        в олимпиадах МПГУ, получать акутальные данные о проходном балле, конкурсе направлений подготовки, следить
        за конкурсной ситуацией во время приемной кампании и многое другое</p>
    <p align="justify">Для начала пользования сервисами поступающего необходимо завести личный кабинет.</p>

    <a class="btn btn-primary btn-lg mpgu-btn" href="signup" role="button">завести Личный
        кабинет</a>

    <?php endif ?>

</div>

<div class="container">

</div>



