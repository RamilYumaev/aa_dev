<?php
/* @var $this yii\web\View */
/* @var $gender string */

/* @var $profile array */
/* @var  $isDlnr boolean */

/* @var $passport array */

/* @var $education array */

/* @var $name \common\auth\models\DeclinationFio */

/* @var $cg array */


/* @var $statementConsent modules\entrant\models\StatementConsentCg */
$nameFull = $profile['last_name'] . " " . $profile['first_name'] . " " . $profile['patronymic'];

?>
<div class="fs-15" style="margin-top: 80px">
    <p align="center"><strong>заявление</strong>.</p>


    <p align="justify" class="lh-1-5">
        Я, <?= $nameFull ?>, <?= $passport['date_of_birth'] ?> года рождения
        <?= $profile['gender'] == "мужской" ? "согласен" : "согласна" ?>
        на зачисление на 1 курс в <?= $cg['faculty'] ?>.
    </p>

    <?php $educationDocument = "серия: " . $education['series'] . " номер: " . $education['number'] . ", выданный: "
        . $education['school_id'] . ", год выдачи: " . $education['year'] ?>

    <p><strong>Направление подготовки:</strong> <?= $cg['specialty'] ?>.</p>
    <?php
    if ($cg['education_level'] == \dictionary\helpers\DictCompetitiveGroupHelper::EDUCATION_LEVEL_BACHELOR) {
        $specialization = "<p><strong>Профиль бакалавриата: </strong>" . $cg['specialization'] . ".";
    } elseif ($cg['education_level'] == \dictionary\helpers\DictCompetitiveGroupHelper::EDUCATION_LEVEL_MAGISTER) {
        $specialization = "<p><strong>Магистерская программа: </strong>" . $cg['specialization'] . ".";
    } elseif ($cg['education_level'] == \dictionary\helpers\DictCompetitiveGroupHelper::EDUCATION_LEVEL_GRADUATE_SCHOOL) {
        $specialization = "<p><strong>Основная профессиональная образовательная программа: </strong>" . $cg['specialization'] . ".";
    } else {
        $specialization = "";
    }
    ?>

    <?= $specialization ?>
    <p><strong>Основание приема:</strong> <?= $cg['special_right'] ?>.

    <p><strong>Форма обучения:</strong> <?= $cg['edu_form'] ?>.</p>

    <p><strong>Вид финансирования:</strong> <?= $cg['financing_type_id'] ?>.</p>
    <?php
    $is086 = "";
    if ($cg['is086']) {
        $is086 = $cg['financing_type_id'] == "Бюджет" || $cg['foreigner_status'] ? " и медицинскую справку по форме 086/у" : " и предоставления медицинской
справки по форме 086/у";
    } ?>

    <p align="justify" class="lh-1-5">
        <?php if($isDlnr && $cg['financing_type_id'] == "Бюджет"): ?>
            Обязуюсь до конца обучения <?= "предоставить в МПГУ оригинал документа об образовании $educationDocument, удостоверяющего образование соответствующего уровня,
            необходимого для зачисления на места за счет бюджетных ассигнований федерального бюджета."?>
        <?php elseif($cg['financing_type_id'] != "Бюджет") : ?>
            Обязуюсь в течение первого года обучения
            <?= $cg['foreigner_status'] ?
                "предоставить в отдел по работе с иностранными учащимися, 
            нотариально заверенный перевод документа об образовании $educationDocument$is086." :
                "явиться (вместе с Заказчиком)
                в приемную комиссию МПГУ для личного подписания оригинала Договора." ?>
        <?php endif; ?>
    </p>
    <table width="100%" class="mt-20 fs-15">
        <tr>
            
            <td width="15%" style="font-size:12px;"><?= date("d.m.Y") ?> г.</td>
            <td class="bb" width="35%"></td>
            <td width="50%" style="font-size:12px;"><?= $nameFull ?></td>

        </tr>
        <tr>
            
            <td></td>
            <td width="35%" class="v-align-top text-center" style="font-size:9px;">(подпись поступающего)</td>
            <td width="50%"></td>

        </tr>
    </table>
</div>

