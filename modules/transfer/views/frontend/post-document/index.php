<?php
/* @var $this yii\web\View */
/* @var $transfer modules\transfer\models\TransferMpgu */

use dictionary\helpers\DictCompetitiveGroupHelper;
use modules\entrant\helpers\AgreementHelper;
use modules\entrant\models\UserDiscipline;
use yii\helpers\Html;

\frontend\assets\modal\ModalAsset::register($this);

$this->title = 'Загрузка документов';
$this->params['breadcrumbs'][] = ['label' => 'Заполнение персональной карточки', 'url' => ['/transfer/default/index']];
$this->params['breadcrumbs'][] = $this->title;

$userId = $transfer->user_id;
?>

<div class="container">
    <div class="row min-scr">
        <div class="button-left">
            <?= Html::a(Html::tag("span", "", ["class" => "glyphicon glyphicon-arrow-left"]). " Карточка",
                "/transfer", ["class" => "btn btn-warning btn-lg"]) ?>
        </div>
    </div>
    <h1 align="center"><?= $this->title ?></h1>
    <div class="row">
        <h4>Требования к согласию на обработку персональных данных:</h4>
        <p class="label label-warning fs-15">Каждая страница заявления о согласии на обработку персональных данных
            загружается отдельно</p>
        <?= \modules\transfer\widgets\statement\StatementPersonalDataWidget::widget(['userId' => $userId]); ?>

        <h4>Требования к паспорту:</h4>
            <p align="justify">
                В образ паспорта должны быть включены все сведения, включая реквизиты (серию и номер) паспорта
                и фотографию гражданина. На фотографии не должно быть бликов, явных отражений голограмм.
                Предоставляются копии 2, 3 и 5 страниц (либо иной страницы, содержащей актуальные сведения
                о месте постоянной регистрации гражданина). Допускаются узкие поля по краям без присутствия
                посторонних предметов (частей тела, элементов одежды, т.п.).</p>
            <?= \modules\transfer\widgets\passport\PassportMainWidget::widget(['view' => 'file', 'userId' => $userId]); ?>

            <?= \modules\transfer\widgets\address\AddressFileWidget::widget(['userId' => $userId]); ?>

            <h4>Требования к документу СНИЛС:</h4>
            <p align="justify"> необходимо загрузить подтверждающий скан (скан карточки или скриншот из личного кабинета)</p>
            <?= \modules\transfer\widgets\insurance\InsuranceWidget::widget(['view' => 'file', 'userId' => $userId]); ?>

            <?= \modules\transfer\widgets\generate\GeneratePacketWidget::widget(['userId' => $userId, 'type' => $transfer->type]);  ?>
            <p class="label label-warning fs-15">Каждая страница заявления
                загружается отдельно</p>
            <?= \modules\transfer\widgets\generate\GenerateStatementWidget::widget(['userId' => $userId]);  ?>

        </div>
    </div>
    <div class="row mb-30">
        <div class="col-md-offset-4 col-md-4">
            <?= Html::a("Отправить в приемную комиссию", ['post-document/send'], ["class" => "btn btn-success btn-lg", 'data'=> ['method' => 'post']]) ?>
        </div>
    </div>
</div>
