<?php
/* @var $this yii\web\View */
/* @var $gender string */

/* @var $anketa array */

use dictionary\helpers\DictCompetitiveGroupHelper;
use modules\entrant\helpers\IndividualAchievementsHelper;

/* @var $statementIA modules\entrant\models\StatementIndividualAchievements */
/* @var $item modules\entrant\models\UserIndividualAchievements */

?>
<div class="mt-25">
    <p align="center" class="bg-light-gray">Заявление <?= $statementIA->numberStatement ?> </p>
    <p align="justify">Прошу рассмотреть предъявленные мной индивидуальные достижения и/или документ(ы),
        подтверждающие наличие особых прав и/или преимуществ, указанных в пунктах 33, 37 и 38 Порядка приема
        на обучение по образовательным программам высшего образования – программам бакалавриата, программам
        специалитета, программам магистратуры, утвержденного Приказом Министерства образования и науки РФ от 21.08.2020 № 1076, для начисления дополнительных баллов при приеме на обучение по программе(ам)
        <strong><?= DictCompetitiveGroupHelper::getEduLevelsGenitiveNameOne($statementIA->edu_level) ?></strong> в 2021
        году:</p>

    <table width="100%" class="app-table">
        <tr>
            <th class="h-50">№<br/>п/п</th>
            <th>Наименование индивидуального достижения</th>
            <th>Отметка о принятии к учету <br/><span class="fs-7">(заполняется сотрудником ПК)</span></th>
        </tr>
        <?php foreach ($statementIA->statementIa as $key => $item) : ?>
            <tr>
                <td class="h-41"><?= ++$key ?></td>
                <td><?= $item->dictIndividualAchievement->name ?></td>
                <td></td>
            </tr>
        <?php endforeach; ?>
    </table>
    <p align="center" class="bg-light-gray">Обязательная часть</p>
    <p align="justify">Своей подписью я подтверждаю, что все перечисленные и представленные мной документы являются
        подлинными и получены законным путем.</p>
    <?php if ($statementIA->edu_level == DictCompetitiveGroupHelper::EDUCATION_LEVEL_BACHELOR): ?>
        <p align="justify">
            С условиями предоставления особых прав и преимуществ, указанных в пт 33, 37 и 38 Порядка приема на обучение
            по образовательным программам высшего образования – программам бакалавриата, программам специалитета,
            программам магистратуры, утвержденного Приказом Министерства образования и науки РФ от 21.08.2020 № 1076
            ознакомлен(а).
        </p>
    <?php endif; ?>
    <p align="justify">
        <?php if(($statementIA->edu_level == DictCompetitiveGroupHelper::EDUCATION_LEVEL_GRADUATE_SCHOOL)):?>
            Я осведомлен(а) о том, что согласно пункту 10.1 Правил приёма срок рассмотрения заявления по учету
            индивидуальных достижений составляет 14 дней (в рамках установленных сроков приема документов).
        <?php else :?>
            Я осведомлен(а) о том, что согласно пункту 14.1 Правил приема заявление рассматривается подкомиссией
            по учету индивидуальных достижений в течение  3х рабочих дней ((в рамках установленных сроков приема документов на обучение по образовательным программам бакалавриата и магистратуры).
        <?php endif;?>
    </p>
    <table width="100%">
        <tr>
            <td>Дата оформления заявления: <?= date("d.m.Y") ?></td>
            <td class="text-right">Подпись</td>
            <td class="bb"></td>
        </tr>
        <tr>
            <td></td>
            <td></td>
            <td align="center">(подпись поступающего)</td>
        </tr>
    </table>
</div>


