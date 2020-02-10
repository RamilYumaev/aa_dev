<?php

use olympic\helpers\OlimpicCgHelper;
use yii\helpers\Html;
use xj\qrcode\QRcode;
use xj\qrcode\widgets\Text;
use olympic\helpers\PersonalPresenceAttemptHelper;
use olympic\helpers\auth\ProfileHelper;
use common\auth\helpers\UserSchoolHelper;
use dictionary\helpers\DictSchoolsHelper;

/** @var \yii\web\View $this */

$olympic = \olympic\helpers\OlympicListHelper::olympicOne($model->olimpic_id);
$profile = ProfileHelper::profileFullName($model->user_id);
$teacher = ProfileHelper::profileFullName(Yii::$app->user->identity->getId());
$this->title = "Благодарность.".$teacher;
?>
<p class="fio">
    <?= $profile ?>
</p>
<p class="school">
    <?= DictSchoolsHelper::schoolName(UserSchoolHelper::userSchoolId($model->user_id, $olympic->year)) ??
    DictSchoolsHelper::preSchoolName(UserSchoolHelper::userSchoolId($model->user_id, $olympic->year))?>
</p>
<p>

</p>
<p class="reward">
    является <?= PersonalPresenceAttemptHelper::nameOfPlacesForCertOne($model->reward_status_id) ?>
</p>
<p class="nomination">
    <?= $model->nomination_id ? '«' . \olympic\helpers\OlympicNominationHelper::olympicName($model->nomination_id) . '»' : ''  ?>
</p>
<p class="olimpic">
    <?= $olympic->genitive_name . ' ' .  $olympic->year ?>
</p>
<p align="center">
    <?php
    $file = Yii::getAlias('@frontendInfo')
        . DIRECTORY_SEPARATOR
        . 'signature'
        . DIRECTORY_SEPARATOR
        . $olympic->chairman_id
        . '.png';
    if (file_exists($file)) {
        echo Html::img('@frontendInfo' . DIRECTORY_SEPARATOR
            . 'signature'
            . DIRECTORY_SEPARATOR
            . $olympic->chairman_id
            . '.png');
    }
    ?>
</p>
Председатель
оргкомитета <?= $olympic->genitive_name . ', <br/>' . '<strong>' . \dictionary\helpers\DictChairmansHelper::chairmansFullNameOne($olympic->chairman_id) . '</strong>' ?>






