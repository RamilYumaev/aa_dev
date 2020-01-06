<?php
use yii\helpers\Html;
use common\helpers\DateTimeCpuHelper;
use olympic\helpers\auth\ProfileHelper;

/** @var \yii\web\View $this */
/** @var $olympic \olympic\models\OlimpicList */

$userName = ProfileHelper::profileName($model->user_id);
$this->title = 'Приглашение. ' . $userName;

$generator = new Picqer\Barcode\BarcodeGeneratorSVG();
$code = $model->user_id. '-'.$model->type .'-'.$model->value;
?>
<div class="container">
    <div class="printDiv">
        <div class="row">
            <div class="col-md-2 col-xs-2">
                <p align="center" class="mt-30">
                    <?= Html::img('@web/img/logo-mpgu.png', ['width' => '90px', 'height' => '90px']); ?>
                </p>
            </div>
            <div class="col-md-8 col-xs-10">
                <h5 align="center">
                    Министерство науки и высшего образования Российской Федерации
                </h5>
                <h5 align="center">
                    Федеральное государственное бюджетное образовательное учреждение высшего образования
                </h5>
                <h4 align="center">
                    <strong>«Московский педагогический государственный университет»</strong>
                </h4>
                <p class="ml-60">
                    ул. М. Пироговская д. 1, стр.1, Москва,119991, ГСП-1<br/>
                    Тел: +7 (499)245-03-10, факс: +7 (499)245-77-58, e-mail: mail@mpgu.su<br/>
                    ОКПО 02079566, ОГРН 1027700215344, ИНН/КПП 7704077771/770401001
                </p>
            </div>
        </div>
        <div class="row mt-50">
            <div class="col-md-10 col-xs-10 col-md-offset-1 col-xs-offset-1">
                <h3 align="center">
                    <strong>Приглашение на очный тур <br/><?= $olympic->genitive_name ?></strong>
                </h3>
                <h4 align="center"><strong>Уважаемый(ая) <?= $userName  ?>!</strong></h4>

                <p class="fs-15 mt-30" align="justify">
                    Приглашаем Вас принять участие в очном туре.
                    Мероприятие состоится
                    <?= DateTimeCpuHelper::getDateChpu($olympic->date_time_start_tour)
                    . ' в '
                    . DateTimeCpuHelper::getTimeChpu($olympic->date_time_start_tour) ?>
                    по адресу: <?= $olympic->address . '. ' . $olympic->required_documents ?>
                    Также необходимо распечатать и принести данное Приглашение со штрих-кодом.
                </p>
                <div class="row mt-50">
                    <div class="col-md-7 col-xs-5">
                        <p align="right">
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
                    <div class="col-md-5 col-xs-7">
                        <p align="right" class="fs-15">
                            Председатель оргкомитета <br/><?= $olympic->genitive_name ?>,<br/>
                            <strong><?= \dictionary\helpers\DictChairmansHelper::chairmansFullNameOne($olympic->chairman_id)  ?></strong>
                        </p>
                    </div>
                </div>

            </div>
        </div>

        <div class="row">
            <div class="col-md-6 col-md-offset-3 col-xs-6 col-xs-offset-3 mt-30">

                <p align="center" class="mt-60">
                    <?= $generator->getBarcode($code, $generator::TYPE_CODE_128) . '<br/>' . $code; ?>
                </p>
            </div>
        </div>
    </div>
