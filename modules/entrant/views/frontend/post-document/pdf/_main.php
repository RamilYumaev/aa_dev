<?php
/* @var $this yii\web\View */

use modules\entrant\helpers\AnketaHelper;
use olympic\helpers\auth\ProfileHelper;



$profile = ProfileHelper::dataArray($userId);

?>
<h3>Расписка</h3>
Фамилия: <?= $profile['last_name'] ?><br/><br/>Имя: <?= $profile['first_name'] ?>
<?=$profile['patronymic'] ? "Отчество: ". $profile['patronymic'] : "";?>
  Контактный телефон: <?= $profile['phone'] ?>
  E-mail: <?= $profile['email'] ?>
