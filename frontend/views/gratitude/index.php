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
$label = '@web/img/certificate/gratitude.png';
?>
<div class="container-fluid">
    <div class="hide-print pl-30">
        <?=Html::a("Как правильно распечатать благодароность", "/instructions/diplom_print.pdf")?>
    </div>
    <div class="row cert-bg gratitude-place">
        <div class="white-bg cert-body">
            <div class="row">
                <div class="col-md-3 col-xs-3">
                    <p align="center" class="pt-60">
                        <?= Html::img('@web/img/old_logo.png', ['width' => '175px', 'height' => '175px']); ?>
                    </p>
                </div>
                <div class="col-md-6 col-xs-6 mt-30">
                    <h5 align="center">
                        Министерство науки и высшего образования Российской Федерации
                    </h5>
                    <h5 align="center">
                        Федеральное государственное бюджетное образовательное учреждение высшего образования
                    </h5>
                    <h4 align="center">
                        <strong>«Московский педагогический государственный университет»</strong>
                    </h4>
                    <p align="center">
                        <?= Html::img($label, ['width' => '650px']) ?>
                    </p>
                    <h3 align="center">Оргкомитет <?= $olympic->genitive_name." ".$olympic->year ?> сообщает, что</h3>
                </div>
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

                <div class="row">
                    <div class="col-md-10 col-xs-10 col-md-offset-1 col-xs-offset-1">
                        <p align="center" class="fio">
                            <?= $teacher ?>
                        </p>
                        <p class="school">
                            <?php foreach ($schoolId  as $item) : ?>
                                <?= \dictionary\helpers\DictSchoolsHelper::schoolName($item).";" ?>
                            <?php endforeach; ?>
                        </p>
                        <p class="reward">
                            Принимал активное участие в подготовке следующего участника олимпиады, занявшего призовое место:
                        </p>
                        <p class="nomination">
                            ФИО участника: <?= $profile ?>;
                        </p>
                        <p class="reward">
                            Призовое место: <?= PersonalPresenceAttemptHelper::nameOfPlacesOne($diploma->reward_status_id) ?>.
                        </p>

                        <p class="nomination">
                            Уважаемый(-ая)  <?= ProfileHelper::profileName($model->user_id)?>! </p>
                        <p class="reward">    Выражаем Вам глубокую благодарность и признательность за Ваш педагогический талант и высокий профессионализм! Желаем Вам процветания и дальнейших успехов в педагогической деятельности!

                        </p>



                    </div>
                </div>

                <div class="mt-30">
                    <div class="row">
                        <div class="col-md-offset-3 col-xs-offset-3 col-md-4 col-xs-4">
                            <p align="center">
                                <?php
                                $file = Yii::getAlias('@webroot')
                                    . DIRECTORY_SEPARATOR
                                    . 'signature'
                                    . DIRECTORY_SEPARATOR
                                    . $olympic->chairman_id
                                    . '.png';
                                if (file_exists($file)) {
                                    echo Html::img('@web' . DIRECTORY_SEPARATOR
                                        . 'signature'
                                        . DIRECTORY_SEPARATOR
                                        . $olympic->chairman_id
                                        . '.png');
                                }
                                ?>
                            </p>
                        </div>
                        <div class="col-md-4 col-xs-4 fs-25">
                            Председатель
                            оргкомитета <?= $olympic->genitive_name . ', <br/>' . '<strong>' . \dictionary\helpers\DictChairmansHelper::chairmansFullNameOne($olympic->chairman_id) . '</strong>' ?>
                        </div>
                    </div>
                </div>


            </div>

        </div>

    </div>
</div>



