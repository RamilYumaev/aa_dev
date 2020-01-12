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
/** @var $olympic \olympic\models\OlimpicList */

$profile = ProfileHelper::profileFullName($model->user_id);
$this->title = (isset($model->reward_status_id) ? 'Диплом. ' : 'Сертификат.') .$profile;
?>

<div class="container-fluid">
    <div class="hide-print pl-30">
        <?=Html::a("Как правильно распечатать диплом", "/instructions/diplom_print.pdf")?>
    </div>
    <div class="row cert-bg <?php
    $label = '';
    switch ($model->reward_status_id) {
        case  PersonalPresenceAttemptHelper::FIRST_PLACE  :
            echo 'win';
            $label = '@web/img/certificate/winn-label.png';
            break;
        case  PersonalPresenceAttemptHelper::SECOND_PLACE :
            echo 'second-place';
            $label = '@web/img/certificate/second-place-label.png';
            break;
        case  PersonalPresenceAttemptHelper::THIRD_PLACE :
            echo 'third-place';
            $label = '@web/img/certificate/third-place-label.png';
            break;
        case  null :
            echo 'certificate-place';
            $label = '@web/img/certificate/certificate.png';
            break;
        case  PersonalPresenceAttemptHelper::NOMINATION :
            echo 'nomination-place';
            $label = '@web/img/certificate/winn-nomination.png';
            break;
    }
    ?>">

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
                    <h3 align="center">Настоящий <?= isset($model->reward_status_id) ? 'диплом' : 'сертификат' ?>
                        удостоверяет, что </h3>
                </div>
                <div class="col-md-3 col-xs-3 mt-30">
                    <p style="color: #565656" align="center"><i>Проверка<br/>подлинности:</i></p>
                    <p align="center">
                        <?= Text::widget([
                            'outputDir' => '@webroot/qr',
                            'outputDirWeb' => '@web/qr',
                            'ecLevel' => QRcode::QR_ECLEVEL_L,
                            'text' => 'https://sdo.mpgu.org/diploma/index?id=' . $model->id,
                            'size' => 5,
                        ]);
                        ?>
                    </p>
                </div>

                <div class="row">
                    <div class="col-md-10 col-xs-10 col-md-offset-1 col-xs-offset-1">
                        <p align="center" class="fio">
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


                <div class="container-fluid ml-30 mr-30 mt-30">
                    <table class="v-a-b">
                        <tr>
                            <td valign="bottom">
                                <p class="small-text">*Дополнительные баллы будут начислены при личном предъявлении (или
                                    через доверенное лицо) данного диплома в подкомиссию по учету индивидуальных
                                    достижений МПГУ и только при поступлении на следующие образовательные
                                    программы: <?=  OlimpicCgHelper::cgOlympicCompetitiveGroupList($olympic->id) ?></p>
                            </td>
                        </tr>
                    </table>
                </div>

            </div>

        </div>

    </div>
</div>
