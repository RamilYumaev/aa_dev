<?php
/* @var $this yii\web\View */
/* @var $other \modules\entrant\models\OtherDocument */

use modules\entrant\helpers\DocumentEducationHelper;
use olympic\helpers\auth\ProfileHelper;
use modules\entrant\helpers\PassportDataHelper;
use yii\helpers\Html;

$profile = ProfileHelper::dataArray($userId);
$name = \common\auth\helpers\DeclinationFioHelper::userDeclination($userId);
$passport = PassportDataHelper::dataArray($userId);
$education = DocumentEducationHelper::dataArray($userId);
$others = \modules\entrant\models\OtherDocument::find()
    ->andWhere(['user_id' => $userId])
    ->andWhere('number IS NOT NULL')->all();

$nameFull = $name->genitive ?? $profile['last_name'] . " " . $profile['first_name'] . " ".$profile['patronymic'];
// $education = \modules\entrant\models\DocumentEducation::findOne(['user_id' => $statementConsent->statementCg->statement->user_id]);

?>

<table width="100%">
    <tr>
        <td><?=Html::img(\Yii::$app->params["staticPath"]."/img/incoming/logo.png")?></td>
        <td class="v-align-center text-center fs-10"><p>
                    ФЕДЕРАЛЬНОЕ ГОСУДАРСТВЕННОЕ БЮДЖЕТНОЕ ОБРАЗОВАТЕЛЬНОЕ УЧРЕЖДЕНИЕ
                   ВЫСШЕГО ОБРАЗОВАНИЯ </br> 
                   <strong> «МОСКОВСКИЙ ПЕДАГОГИЧЕСКИЙ ГОСУДАРСТВЕННЫЙ УНИВЕРСИТЕТ»</strong>

                </p></td>
    </tr>
</table>

<div class="fs-15" style="margin-top: 80px" style="page-break-after: always;">
    <p align="center"><strong>РАСПИСКА № <?= $userId ?></strong></p>

<p align="justify" class="lh-1-5">
документов, принятых от поступающего <strong><?=$nameFull;?></strong>
<table width="100%" class="table table-bordered app-table fs-15">
  <tr>
    <td width="10%">№ п/п</td>
    <td style="text-align: left; padding-left: 10px">Наименование документа</td>
  </tr>
  <tr>
    <td>1</td>
    <td style="text-align: left; padding-left: 10px">Заявление поступающего</td>
  </tr>
  <tr>
    <td>2</td>
    <td style="text-align: left; padding-left: 10px"><?= $education['type'] . " " . $education['series'] . " " . $education['number']?>, копия</td>
  </tr>
  <tr>
    <td>3</td>
    <td style="text-align: left; padding-left: 10px"><?= $passport['type'] . " " . $passport['series'] . " " . $passport['number']?>, копия</td>
  </tr>
  <tr>
    <td>4</td>
    <td style="text-align: left; padding-left: 10px">Фотографии</td>
  </tr>
        <?php $i=5; foreach ($others as $other) :  ?>
            <tr>
                <td><?= $i++; ?></td>
                <td style="text-align: left; padding-left: 10px"><?= $other->typeName . " " . $other->series . " " . $other->number?>, копия</td>
            </tr>
        <?php endforeach; ?>
</table>


<!-- <div style="page-break-after: always;"> -->
    
    <table width="100%" class="mt-50 fs-15">
        <tr>
            
            <td width="15%"><?= date("d.m.Y") ?> г.</td>
            <td class="bb" width="25%"></td>
            <td class="bb" width="35%"></td>

        </tr>
        <tr>
            <td width="25%"></td>
            <td width="35%" class="v-align-top text-center">(подпись сотрудника ОК)</td>
            <td width="35%" class="v-align-top text-center">(ФИО сотрудника ОК)</td>
            <td width="10%"></td>

        </tr>
    </table>
</div>

<div class="fs-15" style="text-align:center">
  <strong>Внимание!</strong><br>
  <p>
Расписка является важным документом и её необходимо сохранять до принятия решения <br>
Приемной комиссией о Вашем зачислении в учебное заведение!
</p>
<p>
В случае утери расписки Вы немедленно должны заявить об этом в Приемную комиссию!
</p>
<p>
Напоминаем, что документы, поданные абитуриентом в Приемную комиссию, могут быть возвращены владельцу только на основании письменного заявления и при наличии расписки.
</p>


</div>

