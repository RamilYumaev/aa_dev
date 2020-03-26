<?php

use yii\helpers\Html;


$this->title = 'Личный кабинет поступающего в МПГУ';
?>


<div class="row mt-30">
    <div class="col-md-2" align="center">
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

        <div class="col-md-2" align="center">
            <?php if (!Yii::$app->user->isGuest) {
                echo Html::a(Html::img('@web/img/cabinet/olympiads.png')
                    . '<br/>Записаться на олимпиады', '/olympiads');
            } ?>

        </div>

        <div class="col-md-2" align="center">
            <?php if (!Yii::$app->user->isGuest) {
                echo Html::a(Html::img('@web/img/cabinet/dod.png')
                    . '<br/>Записаться на Дни открытых дверей', '/dod');
            } ?>

        </div>
<?php
$array =\yii\helpers\Json::decode(
'{"id":276,"campaign_id":"4","name":"Аспирантура | БИО | БИО | биохимия | о | б","education_level_id":"6","faculty_id":"39","specialty_id":"223","specialization_id":"719","education_program_id":"1","kcp":"88","education_form_id":"1","financing_type_id":"1","special_right_id":null,"second_degree_status":0,"parallel_education_status":0,"foreigner_status":"0","weekend_group_status":0,"education_year_cost":null,"education_duration":"4","course":"1","semester":"1","enquiry_086_u_status":"0","application_current_number":2,"spo_class":null,"eoidot_type_id":"","eoidot_education_year_cost":null,"competition_count":"","competition_mark":"","site_url":"","is_new_status":"0","contract_only_status":"0","faculty_real_id":"39","discount":0,"ums_vpu_status":"0","ums_vpu_cost_1":"","ums_vpu_cost_2":"","ums_vpu_cost_3":"","spo_semester":""}
');
//var_dump($array);
$model= new \dictionary\models\ais\DictIncomingCompetitiveGroup();
$ar1=array_intersect_key($array,$model->attributeAis());
$array2 = [];
$array1=  $model->attributeAis();
foreach ($ar1 as $key => $value) {
       $array2[$array1[$key]]  = $value;
}

var_dump($array2);


?>



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
    <div class="col-md-12">
        <?php if (!Yii::$app->user->isGuest) : ?>
            <?= \frontend\widgets\olympic\UserOlympicListWidget::widget(); ?>
       <?php endif; ?>
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

    <a class="btn btn-primary btn-lg mpgu-btn" href="/auth/signup/request" role="button">завести Личный
        кабинет</a>

    <?php endif ?>

</div>

<div class="container">

</div>



