<?php
/* @var $this yii\web\View */

use modules\entrant\helpers\PassportDataHelper;
use modules\entrant\helpers\AddressHelper;
use modules\entrant\helpers\DocumentEducationHelper;
use \olympic\helpers\auth\ProfileHelper;
use yii\helpers\Html;

/* @var $user_id integer */
/* @var  $profile array */
/* @var  $name string */


$passport = PassportDataHelper::dataArray($user_id);
$nameFull = $name->genitive ?? $profile['last_name'] . " " . $profile['first_name'] . " ".$profile['patronymic'];

?>
<table width="100%">
    <tr>
        <td><?=Html::img(\Yii::$app->params["staticPath"]."/img/incoming/logo.svg")?></td>
        <td class="v-align-center text-center fs-10"><p>
                    ФЕДЕРАЛЬНОЕ ГОСУДАРСТВЕННОЕ БЮДЖЕТНОЕ ОБРАЗОВАТЕЛЬНОЕ УЧРЕЖДЕНИЕ
                   ВЫСШЕГО ОБРАЗОВАНИЯ </br> 
                   <strong> «МОСКОВСКИЙ ПЕДАГОГИЧЕСКИЙ ГОСУДАРСТВЕННЫЙ УНИВЕРСИТЕТ»</strong>

                </p></td>
    </tr>
</table>



