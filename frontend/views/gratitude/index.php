<?php

use yii\helpers\Html;
use xj\qrcode\QRcode;
use xj\qrcode\widgets\Text;
use olympic\helpers\PersonalPresenceAttemptHelper;
use olympic\helpers\auth\ProfileHelper;

/** @var \yii\web\View $this */
/** @var  $schoolId array*/
/** @var  $diploma olympic\models\Diploma*/

$olympic = \olympic\helpers\OlympicListHelper::olympicOne($diploma->olimpic_id);
$profile = ProfileHelper::profileFullName($diploma->user_id);
$teacher = ProfileHelper::profileFullName($model->user_id);
$this->title = "Благодарность.".$teacher;
?>
<h2>
    <?= $this->title ?>
</h2>
<p class="fio">
    <?= $profile ?>
</p>
<p class="school">
    <?php foreach ($schoolId  as $item) : ?>
    <?= \dictionary\helpers\DictSchoolsHelper::schoolName($item).";" ?>
    <?php endforeach; ?>
</p>
<p>
    <div class="col-md-3 col-xs-3 mt-30">
<p style="color: #565656" align="center"><i>Проверка<br/>подлинности:</i></p>
<p align="center">
    <?= Text::widget([
        'outputDir' => '@webroot/qr',
        'outputDirWeb' => '@web/qr',
        'ecLevel' => QRcode::QR_ECLEVEL_L,
        'text' => 'https://sdo.mpgu.org/gratitude/index?id=' . $model->id,
        'size' => 5,
    ]);
    ?>
</p>
</div>

</p>
<p class="reward">
    является <?= PersonalPresenceAttemptHelper::nameOfPlacesForCertOne($diploma->reward_status_id) ?>
</p>
<p class="nomination">
    <?= $diploma->nomination_id ? '«' . \olympic\helpers\OlympicNominationHelper::olympicName($diploma->nomination_id) . '»' : ''  ?>
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





