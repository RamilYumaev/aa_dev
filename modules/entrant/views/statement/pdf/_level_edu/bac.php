<?php
/* @var $this yii\web\View */

use modules\entrant\helpers\ItemsForSignatureApp;

/* @var $userCg array */

$fontFamily = "font-family: 'Times New Roman';";
$fontSize = "font-size: 10px;";
$fontSize7px = "font-size: 7px;";
$borderStyle = "border: 1px solid black;";
$padding = "padding-top: 15px;";
$borderCollapse = "border-collapse: collapse;";
$alignCenter = "align=\"center\"";
$verticalAlign = "vertical-align: middle;";
$verticalAlignTop = "vertical-align: top;";
$generalStyle = $borderStyle . " " . $verticalAlign;

?>

<table class="table table-bordered" style="<?= $fontFamily ?> <?= $fontSize ?> <?= $borderCollapse ?>">
    <tbody>
    <tr>
        <th style="<?= $generalStyle ?>" rowspan="2">№</th>
        <th style="<?= $generalStyle ?>" colspan="3" align="center">Условия поступления</th>
        <th style="<?= $generalStyle ?>" rowspan="2" <?= $alignCenter ?>>Основание приема</th>
        <th style="<?= $generalStyle ?>" align="center" colspan="2">Вид финансирования</th>
    </tr>
    <tr>
        <th style="<?= $generalStyle ?>">Направление подготовки</th>
        <th style="<?= $generalStyle ?>">Образовательная программма</th>
        <th style="<?= $generalStyle ?>">Форма обучения</th>
        <th style="<?= $generalStyle ?>">Федеральный бюджет</th>
        <th style="<?= $generalStyle ?>">Платное обучение</th>
    </tr>
    <?php foreach ($userCg as $key => $value) : ?>
        <tr>
            <td width="4%" style="<?= $generalStyle ?>"><?= ++$key ?>.</td>
            <td width="30%" style="<?= $generalStyle ?>"><?= $value["speciality"] ?></td>
            <td width="30%" style="<?= $generalStyle ?>"><?= $value['specialization'] ?></td>
            <td width="10%" style="<?= $generalStyle ?>" <?= $alignCenter ?>><?= $value['form'] ?></td>
            <td width="11%" style="<?= $generalStyle ?>" <?= $alignCenter ?>><?= $value['special_right'] ?></td>
            <td width="13%" style="<?= $generalStyle ?>" <?= $alignCenter ?>>
                <?= $value['budget'] ?? "" ?></td>
            <td width="10%" style="<?= $generalStyle ?>" <?= $alignCenter ?>><?= $value['contract'] ?? "" ?></td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>
<p style="<?= $fontFamily . " " . $fontSize ?>">
    Прошу в качестве вступительных испытаний засчитать следующие результаты ЕГЭ: Русский язык - 60 балла(-ов),
    Обществознание - 50 балла(-ов), Иностранный язык - английский - 70 балла(-ов), История – 70 балла(-ов).
</p>
<p style="<?= $fontFamily . " " . $fontSize ?>">
    Прошу допустить меня к вступительным испытаниям по следующим предметам: История.<br/>
    Основание для допуска к сдаче вступительных испытаний: диплом среднего профессионального образования.
</p>
<p align="center"><strong>О себе сообщаю следующее:</strong></p>

<table style="<?= $fontFamily . " " . $fontSize . " " . $verticalAlignTop ?>">
    <tr>
        <td>
            В общежитии: Не нуждаюсь<br/>
            Изучил(а) иностранные языки: Английский<br/>
            Сведения о наличии особых прав для поступающих на программы бакалавриата Не имею <br/>
            Имею преимущественное право при зачислении:<br/>
        </td>
        <td>Пол: Мужской</td>
    </tr>
</table>
<table width="100%" style="<?= $fontFamily . " " . $fontSize ?>">
    <tr>
        <td></td>
        <td style="<?= $borderStyle ?>" width="30px" height="15px"></td>
        <td width="100px">Имею</td>
        <td style="<?= $borderStyle . " " . $verticalAlign ?>" <?= $alignCenter ?> width="30px" height="15px">X</td>
        <td>Не имею</td>
    </tr>
</table>
<p style="<?= $fontFamily . " " . $fontSize ?> margin: 20px 0" <?= $alignCenter ?>><strong>Примечания:</strong></p>

<p align="justify" style="<?= $fontFamily . " " . $fontSize ?>">
    В случае наличия индивидуальных достижений и/или особых прав и преимуществ, указанных в пунктах 33, 37 и 38 Порядка
    приема на обучение по образовательным программам высшего образования – программам бакалавриата, программам
    специалитета, программам магистратуры, утвержденного Приказом Министерства образования и науки РФ от 14.10.2015
    № 1147, сведения о них отображаются в заявлении об учете индивидуальных достижений и соответствующих особых прав
    и преимуществ в дополнение к заявлению на участие в конкурсе.
</p>

<?php

$signaturePoint = ItemsForSignatureApp::GENERAL_BACHELOR_SIGNATURE;

foreach ($signaturePoint as $signature) :?>

    <p style="margin: 10px 0"><?= ItemsForSignatureApp::getItemsText()[$signature] ?></p>
    <?php if ($signature == ItemsForSignatureApp::SPECIAL_CONDITIONS) : ?>
        <table width="100%" style="<?= $fontFamily . " " . $fontSize ?>">
            <tr>
                <td></td>
                <td style="<?= $borderStyle ?>" width="30px" height="15px"></td>
                <td width="100px">Нуждаюсь</td>
                <td style="<?= $borderStyle . " " . $verticalAlign ?>" <?= $alignCenter ?> width="30px" height="15px">
                    X
                </td>
                <td>Не нуждаюсь</td>
            </tr>
        </table>
    <?php endif; ?>
    <table width="100%">
        <tr>
            <td width="80%" rowspan="2"></td>
            <td style="border-bottom: 1px solid black;"></td>
        </tr>
        <tr>
            <td style="<?= $fontSize7px . " " . $fontFamily . " " . $verticalAlignTop ?>" <?= $alignCenter ?>>(Подпись
                поступающего)
            </td>
        </tr>
    </table>
<?php endforeach; ?>
<div style="margin-top:50px">
    <table>
        <tr>
            <td>«</td>
            <td width="20px" style="border-bottom: 1px solid black"></td>
            <td>»</td>
            <td width="40px" style="border-bottom: 1px solid black"></td>
            <td style="<?= $fontFamily . " " . $fontSize ?>">2020</td>
            <td style="<?= $fontFamily . " " . $fontSize ?>">г.</td>
            <td width="470px"></td>
            <td width="145px" style="border-bottom: 1px solid black"></td>
        </tr>
        <tr>
            <td colspan="6" style="text-align: right; <?= $fontSize7px ?>">(Дата заполнения)</td>
            <td></td>
            <td align="center" style="<?= $fontSize7px . " " . $fontFamily ?>">(Подпись поступающего)</td>
        </tr>
    </table>
    <div style="margin-top:30px">
        <table style="<?= $fontSize . " " . $fontFamily ?>">
            <tr>
                <td><strong>Подпись сотрудника ОК, принявшего заявление</strong></td>
                <td width="120px" style="border-bottom: 1px solid black"></td>
                <td>(</td>
                <td width="200px" style="border-bottom: 1px solid black"></td>
                <td>)</td>
                <td></td>
            </tr>
            <tr>
                <td></td>1
                <td align="center" style="<?= $fontSize7px . " " . $fontFamily ?>">(Подпись)</td>
                <td></td>
                <td align="center" style="<?= $fontSize7px . " " . $fontFamily ?>">(Фамилия И.О.)</td>
                <td></td>
                <td></td>
            </tr>
        </table>
        <table style="<?= $fontSize . " " . $fontFamily ?>">
            <tr>
                <td width="50px"></td>
                <td>«</td>
                <td width="50px" style="border-bottom: 1px solid black"></td>
                <td>»</td>
                <td width="50px" style="border-bottom: 1px solid black"></td>
                <td>2020 г.</td>
            </tr>
        </table>
    </div>
</div>
