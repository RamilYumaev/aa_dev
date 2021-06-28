<?php
/* @var $this yii\web\View */
/* @var $gender string */

/* @var $profile array */

/* @var $passport array */

/* @var $education array */

/* @var $name \common\auth\models\DeclinationFio */

/* @var $cg array */


/* @var $statementConsent modules\entrant\models\StatementConsentCg */
$nameFull = $profile['last_name'] . " " . $profile['first_name'] . " " . $profile['patronymic'];

?>
<div class="fs-15" style="margin-top: 100px">
    <p align="center"><strong>Заявление</strong></p>


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
    Подтверждаю, что у меня отсутствуют действительные (не отозванные) заявления о согласии на зачисление на обучение по
    программам <?= ($cg['education_level'] == \dictionary\helpers\DictCompetitiveGroupHelper::EDUCATION_LEVEL_SPO  ? 'среднего профессионального' :'высшего ') ?> образования данного уровня на места в рамках контрольных цифр приема, в том числе, поданные в
    другие организации.

    <p align="justify" class="lh-1-5">
        Обязуюсь в течение первого года обучения
        <?php if ($cg['financing_type_id'] == "Бюджет"): ?>
            <?= $cg['foreigner_status'] ?
                "предоставить в отдел по работе с иностранными учащимися оригинал и 
            нотариально заверенный перевод документа об образовании $educationDocument$is086." :
                "предоставить в МПГУ оригинал документа об образовании $educationDocument, удостоверяющего образование соответствующего уровня,
        необходимого для зачисления на места за счет бюджетных ассигнований федерального бюджета." ?>
        <?php else : ?>
            <?= $cg['foreigner_status'] ?
                "предоставить в отдел по работе с иностранными учащимися, 
            нотариально заверенный перевод документа об образовании $educationDocument$is086." :
                "явиться (вместе с Заказчиком)
                в приемную комиссию МПГУ для личного подписания оригинала Договора$is086." ?>
        <?php endif; ?>
    </p>
    <?php if ($cg['is086']): ?>
        <p align="justify">
            Обязуюсь в течение первого года обучения пройти обязательные предварительные медицинские осмотры
            (обследования)
            при обучении по специальностям и направлениям подготовки, входящим в перечень специальностей и направлений
            подготовки,
            при приеме на обучение по которым поступающие проходят обязательные предварительные медицинские осмотры
            (обследования),
            в порядке, установленном при заключении трудового договора или служебного контракта по соответствующей
            должности или специальности, утвержденном постановлением Правительства Российской Федерации от 14 августа
            2013 г. № 697 и предоставить в МПГУ соответствующие документы.
        </p>
    <?php endif; ?>
    <table width="100%" class="mt-50 fs-15">
        <tr>
            <td width="25%"></td>
            <td width="15%"><?= date("d.m.Y") ?> г.</td>
            <td class="bb" width="35%"></td>
            <td width="25%"><?= $nameFull ?></td>

        </tr>
        <tr>
            <td width="25%"></td>
            <td></td>
            <td width="35%" class="v-align-top text-center">(подпись поступающего)</td>
            <td width="15%"></td>
            <td width="25%"></td>

        </tr>
    </table>
</div>

