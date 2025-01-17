<?php
/* @var $this yii\web\View */
/* @var $gender string */
/* @var $anketa array */

/* @var $statement modules\entrant\models\Statement */
use dictionary\helpers\DictCompetitiveGroupHelper;
use modules\entrant\helpers\FileCgHelper;
use modules\entrant\helpers\AdditionalInformationHelper;
use modules\entrant\helpers\ItemsForSignatureApp;
use modules\entrant\helpers\LanguageHelper;
use modules\entrant\helpers\PreemptiveRightHelper;
use modules\entrant\helpers\UserDisciplineHelper;
use modules\entrant\models\OtherDocument;

$userCg = FileCgHelper::cgUser($statement->user_id, $statement->faculty_id, $statement->speciality_id, $statement->special_right,  $statement->columnIdCg());

$cse = DictCompetitiveGroupHelper::groupByExamsCseFacultyEduLevelSpecializationN($statement->user_id,
    $statement->faculty_id, $statement->speciality_id, $statement->columnIdCg(), 1);
$cseVi = DictCompetitiveGroupHelper::groupByExamsCseFacultyEduLevelSpecializationN($statement->user_id,
    $statement->faculty_id, $statement->speciality_id, $statement->columnIdCg(), 2);
$noCse = DictCompetitiveGroupHelper::groupByExamsCseFacultyEduLevelSpecializationN($statement->user_id,
    $statement->faculty_id, $statement->speciality_id, $statement->columnIdCg(), 3);
$noCseSuccess = DictCompetitiveGroupHelper::groupByExamsNoCseId($statement->user_id,
    $statement->faculty_id, $statement->speciality_id, $statement->columnIdCg(), false);
$language = LanguageHelper::all($statement->user_id);
$information = AdditionalInformationHelper::dataArray($statement->user_id);
$prRight = PreemptiveRightHelper::allOtherDoc($statement->user_id);

$education = \modules\entrant\models\DocumentEducation::findOne(['user_id' => $statement->user_id]);

$isCt = UserDisciplineHelper::isCt($statement->user_id);
$textCt = $isCt ? '/(ЦТ Беларусь)' : '';

$anketaOne= \modules\entrant\models\Anketa::findOne(['user_id'=>$statement->user_id]);
$examBase = "Основание для допуска к сдаче вступительных испытаний:";
$otherDocument = OtherDocument::find()
    ->where(['user_id' => $statement->user_id])->andWhere(['exemption_id'=> 1])->one();

$och = false;
?>

<table class="table table-bordered app-table">
    <tbody>
    <tr>
        <th rowspan="2">№</th>
        <th colspan="3" align="center">Условия поступления</th>
        <?php if ($anketa['category_id'] == \modules\entrant\helpers\CategoryStruct::FOREIGNER_CONTRACT_COMPETITION ||
            $anketa['category_id'] == \modules\entrant\helpers\CategoryStruct::GOV_LINE_COMPETITION): ?>
            <th align="center" rowspan="2">Вид финансирования</th>
        <?php else : ?>
            <th rowspan="2">Основание приема</th>
            <th rowspan="2">Вид финансирования</th>
            <!-- <th align="center" colspan="2">Вид финансирования</th> -->
        <?php endif; ?>
    </tr>
    <tr>
        <th>Направление подготовки</th>
        <th>Образовательная программа</th>
        <th>Форма обучения</th>
        
    </tr>
    <?php foreach ($userCg as $key => $value): if ($value['form'] == "очная") {
        $och = true;
    } ?>
        <tr>
            <td width="4%"><?= ++$key ?>.</td>
            <td width="30%"><?= $value["speciality"] ?></td>
            <td width="30%"><?= $value['specialization'] ?></td>
            <td width="10%"><?= $value['form'] ?></td>
            <?php if ($anketa['category_id'] == \modules\entrant\helpers\CategoryStruct::FOREIGNER_CONTRACT_COMPETITION) : ?>
                <td class="text-center">На места по договорам об оказании платных образовательных услуг</td>
            <?php elseif ($anketa['category_id'] == \modules\entrant\helpers\CategoryStruct::GOV_LINE_COMPETITION) : ?>
                <td class="text-center">За счет бюджетных ассигнований федерального бюджета</td>
            <?php else : ?>
                <td width="11%"><?= $value['special_right'] ?></td>
                <?php if ($value['budget'] != "") : ?>
                <td width="23%" class="text-center">За счет бюджетных ассигнований федерального бюджета
                </td>
                <?php else : ?>
                    <td width="23%" class="text-center">На места по договорам об оказании платных образовательных услуг
                </td>
                <?php endif; ?>
                
            <?php endif; ?>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>


<?php if($cse): ?>
    <p>
        Прошу в качестве вступительных испытаний засчитать следующие результаты (ЕГЭ Россия)<?=$textCt?>: <?= $cse ?>
    </p>
<?php endif; ?>
<?php if ($cseVi): ?>
    <p>
        <?= ($anketa['category_id'] == \modules\entrant\helpers\CategoryStruct::TPGU_PROJECT) ?
            "":
            "Прошу засчитать в качестве балла по предметам ". $cseVi ." наивысший результат по вступительному испытанию или результату (ЕГЭ Россия)".$textCt?>
    </p>
<?php endif; ?>
<?php if($noCse): ?>
    <p>
        Прошу допустить меня к вступительным испытаниям по следующим предметам: <?= $noCse ?><br/>
        <?php if ($noCseSuccess): ?>
            <?php if ($otherDocument): ?>
                <?= $examBase . " " . $otherDocument->typeName . ", " . $otherDocument->otherDocumentFullStatement ?>.
            <?php elseif (\Yii::$app->user->identity->anketa()->is_foreigner_edu_organization) ://@todo?>
                <?= $examBase ?> Документ об образовании <?= $education->documentFull . " " . $education->school->countryRegion ?>
            <?php elseif (\Yii::$app->user->identity->anketa()->spoNpo()): ?>
                <?= $examBase ?> <?= $anketa['currentEduLevel'] ?>.
            <?php endif; ?>
        <?php endif; ?>
    </p>
<?php endif; ?>
<p align="center"><strong>О себе сообщаю следующее:</strong></p>

<table width="100%">
    <tr>
        <td width="80%"> 
                В общежитии: <?= $information['hostel'] ? 'Нуждаюсь' : 'Не нуждаюсь' ?><br/>
            Изучил(а) иностранные языки: <?= $language ?><br/>
        </td>
        <td width="20%">Пол: <?= $gender ?></td>
    </tr>
</table>
<table width="100%">
    <tr>
        <td></td>
        <td class="box-30-15 bordered-cell text-center"><?= $prRight ? "X": "" ?></td>
        <td width="100px">Имею</td>
        <td class="box-30-15 bordered-cell text-center"><?= !$prRight ? "X": "" ?></td>
        <td>Не имею</td>
    </tr>
</table>
<?php if($prRight) :?>
    <p class="underline-text"> на основании: <?= $prRight ?></p>
<?php endif; ?>

<?php if ($anketaOne->is_dlnr_ua) : ?>
    <p align="justify">
        Сведения о принадлежности к категории граждан Российской Федерации, которые до прибытия на территорию Российской Федерации проживали на территории ДНР, ЛНР, Украины, а также граждан Российской Федерации, которые были вынуждены прервать свое обучение в иностранных образовательных организациях: Принадлежу
    </p>
<?php endif; ?>
<p class="mt-20 text-center"><strong>Примечания:</strong></p>
<?php if($anketaOne->isRussia()) :?>
    <p align="justify">
        В случае наличия индивидуальных достижений сведения о них отображаются в заявлении об учете индивидуальных достижений в дополнение к заявлению на участие в конкурсе.В случае наличия индивидуальных достижений и/или особых прав и преимуществ, указанных в пунктах 24, 25 и 27 Порядка
        приема на обучение по образовательным программам высшего образования – программам бакалавриата, программам
        специалитета, программам магистратуры, утвержденного Приказом Министерства образования и науки РФ от 14.10.2015
        № 1147, сведения о них отображаются в заявлении об учете индивидуальных достижений и соответствующих особых прав
        и преимуществ в дополнение к заявлению на участие в конкурсе.
    </p>
<?php else: ?>
    <p align="justify">
        В случае наличия индивидуальных достижений сведения о них отображаются в заявлении об учете индивидуальных достижений в дополнение к заявлению на участие в конкурсе.
    </p>
<?php endif; ?>
<?php
$signaturePoint = ItemsForSignatureApp::GENERAL_BACHELOR_SIGNATURE;
if(!$och) {
    unset($signaturePoint[9]);
}
foreach ($signaturePoint as $signature) :?>

    <p class="mt-15"><?= ItemsForSignatureApp::getItemsText()[$signature] ?></p>
    <?php if ($signature == ItemsForSignatureApp::SPECIAL_CONDITIONS) : ?>
        <table width="100%">
            <tr>
                <td></td>
                <td class="box-30-15 bordered-cell text-center"><?= $information['voz'] ? "X" : "" ?></td>
                <td class="w-100">Нуждаюсь</td>
                <td class="box-30-15 bordered-cell text-center"><?= !$information['voz'] ? "X" : "" ?></td>
                <td>Не нуждаюсь</td>
            </tr>
        </table>
    <?php endif; ?>
    <table width="100%">
        <tr>
            <td width="80%" rowspan="2"></td>
            <td class="bb"></td>
        </tr>
        <tr>
            <td class="v-align-top text-center fs-7">(Подпись поступающего)
            </td>
        </tr>
    </table>
<?php endforeach; ?>
<div class="mt-50">
<table>
        <tr>
            <td>«</td>
            <td class="bb w-20"></td>
            <td>»</td>
            <td class="bb w-40"></td>
            <td>202</td>
            <td class="bb w-20"></td>
            <td>г.</td>
            <td class="w-470"></td>
            <td class="bb w-145"></td>
        </tr>
        <tr>
            <td colspan="6" class="text-right fs-7">(Дата заполнения)</td>
            <td></td>
            <td></td>
            <td class="text-center fs-7">(Подпись поступающего)</td>
        </tr>
    </table>
    <div class="mt-30">
        <table>
            <tr>
                <td><strong>Подпись сотрудника ОК, принявшего заявление</strong></td>
                <td class="bb w-120"></td>
                <td>(</td>
                <td class="bb w-200"></td>
                <td>)</td>
                <td></td>
            </tr>
            <tr>
                <td></td>
                <td class="text-center fs-7">(Подпись)</td>
                <td></td>
                <td class="text-center fs-7">(Фамилия И.О.)</td>
                <td></td>
                <td></td>
            </tr>
        </table>
        <table>
            <tr>
                <td></td>
                <td>«</td>
                <td class="bb w-50"></td>
                <td>»</td>
                <td class="bb w-50"></td>
                <td>202<td class="bb w-20"></td>
                <td>г.</td>
            </tr>
        </table>
    </div>
</div>
