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
use modules\entrant\models\OtherDocument;

$userCg = FileCgHelper::cgUser($statement->user_id, $statement->faculty_id, $statement->speciality_id, $statement->special_right,  $statement->columnIdCg());
$anketaOne= \modules\entrant\models\Anketa::findOne(['user_id'=>$statement->user_id]);
$cse = DictCompetitiveGroupHelper::groupByExamsCseFacultyEduLevelSpecialization($statement->user_id,
    $statement->faculty_id, $statement->speciality_id, $statement->columnIdCg(), true);
$noCse = DictCompetitiveGroupHelper::groupByExamsCseFacultyEduLevelSpecialization($statement->user_id,
    $statement->faculty_id, $statement->speciality_id, $statement->columnIdCg(), false);
$language = LanguageHelper::all($statement->user_id);
$information = AdditionalInformationHelper::dataArray($statement->user_id);
$prRight = PreemptiveRightHelper::allOtherDoc($statement->user_id);
$data= explode(', ', $noCse);
$otherDocumentRight = OtherDocument::find()
    ->where(['user_id' => $statement->user_id])->andWhere(['exemption_id'=> 5])->one();
$och = false;
$isFinanceContract =  false;
?>

<!-- <table class="table table-bordered app-table">
    <tbody>
    <tr>
        <th rowspan="2">№</th>
        <th colspan="2" align="center">Условия поступления</th>
        <th rowspan="2">Основание приема</th>
        <th align="center" colspan="2">Вид финансирования</th>
    </tr>
    <tr>
        <th>Направление подготовки</th>
        <th>Форма обучения</th>
        <th>Федеральный бюджет</th>
        <th>Платное обучение</th>
    </tr>
    <?php foreach ($userCg as $key => $value): if($value['form'] == "очная") { $och = true;} ?>
        <tr>
            <td width="4%"><?= ++$key ?>.</td>
            <td width="30%"><?= $value["speciality"] ?></td>
            <td width="10%"><?= $value['form'] ?></td>
            <td width="11%"><?= $value['special_right'] ?></td>
            <td width="13%">
                <?= $value['budget'] ?? "" ?></td>
            <td width="10%" class="text-center"><?= $value['contract'] ?? "" ?></td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table> -->
<table class="table table-bordered app-table">
    <tbody>
    <tr>
        <th rowspan="2">№</th>
        <th colspan="2" align="center">Условия поступления</th>
        <?php if ($anketa['category_id'] == \modules\entrant\helpers\CategoryStruct::FOREIGNER_CONTRACT_COMPETITION ||
            $anketa['category_id'] == \modules\entrant\helpers\CategoryStruct::GOV_LINE_COMPETITION): ?>
            <th align="center">Вид финансирования</th>
        <?php else : ?>
            <th rowspan="2">Основание приема</th>
            <th rowspan="2">Вид финансирования</th>
            <!-- <th align="center" colspan="2">Вид финансирования</th> -->
        <?php endif; ?>
    </tr>
    <tr>
        <th>Направление подготовки</th>
        <th>Форма обучения</th>

    </tr>
    <?php foreach ($userCg as $key => $value): if ($value['form'] == "очная") {
        $och = true;
    }
     if ($value['budget'] == "") {
         $isFinanceContract = true;
     }
    ?>
        <tr>
            <td width="4%"><?= ++$key ?>.</td>
            <td width="30%"><?= $value["speciality"] ?></td>
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
<?php if($noCse):?>
    <p>
        Основание для участия в конкурсе: Средний балл аттестата.<br/>
        <?= count($data) > 1 ? "Прошу допустить меня к вступительным испытаниям по следующим предметам: ". $data[1] : "" ?>
    </p>
<?php endif; ?>
<p align="center"><strong>О себе сообщаю следующее:</strong></p>
<table width="100%">
    <tr>
        <td width="80%">

            Изучил(а) иностранные языки: <?= $language ?><br/>
            Имею преимущественное право при зачислении:<br/>
        </td>
        <td width="20%">Пол: <?= $gender ?></td>
    </tr>
</table>
<?php if ($anketaOne->isRussia()): ?>
    <table width="100%">
        <tr>
            <td></td>
            <td class="box-30-15 bordered-cell text-center"><?= $prRight ? "X" : "" ?></td>
            <td width="100px">Имею</td>
            <td class="box-30-15 bordered-cell text-center"><?= !$prRight ? "X" : "" ?></td>
            <td>Не имею</td>
        </tr>
    </table>
    <?php if ($prRight) : ?>
        <p class="underline-text"> на основании: <?= $prRight ?></p>
    <?php endif; ?>
    <table width="100%">
        <tr>
            <td width="100%">
                Имею право первоочередного приема в соответствии с частью 4 статьи 68 Федерального закона «Об образовании в Российской Федерации»:<br/>
            </td>
        </tr>
    </table>
    <table width="100%">
        <tr>
            <td></td>
            <td class="box-30-15 bordered-cell text-center"><?= $otherDocumentRight ? "X" : "" ?></td>
            <td width="100px">Имею</td>
            <td class="box-30-15 bordered-cell text-center"><?= !$otherDocumentRight ? "X" : "" ?></td>
            <td>Не имею</td>
        </tr>
    </table>
    <?php if ($otherDocumentRight) : ?>
        <p class="underline-text"> на основании: <?=  $otherDocumentRight->typeName." ".($otherDocumentRight->series ?? "" ). " №".$otherDocumentRight->number.", "; ?></p>
    <?php endif; ?>
<?php endif; ?>

<?php
$signaturePoint = $isFinanceContract ? ItemsForSignatureApp::GENERAL_SPO_CONTRACT : ItemsForSignatureApp::GENERAL_SPO;
if(!$och) {
    unset($signaturePoint[9]);
}

if (count($data) == 1) {
    unset($signaturePoint[2]);
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
                <td></td>1
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
