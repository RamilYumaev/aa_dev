<?php
/* @var $this yii\web\View */

use yii\helpers\Html;

\frontend\assets\modal\ModalAsset::register($this);

$this->title = 'Подача заявления об исключении из приказа о зачислении';

$this->params['breadcrumbs'][] = ['label' => 'Определение условий подачи документов', 'url' => ['/abiturient/anketa/step1']];
$this->params['breadcrumbs'][] = ['label' => 'Выбор уровня образования', 'url' => ['/abiturient/anketa/step2']];
$this->params['breadcrumbs'][] = ['label' => 'Заполнение персональной карточки поступающего', 'url' => ['/abiturient/default/index']];
$this->params['breadcrumbs'][] = $this->title;

$anketa = Yii::$app->user->identity->anketa();
$userId =  Yii::$app->user->identity->getId();
?>

<div class="container">
    <div class="row min-scr">
        <div class="button-left">
            <?= Html::a(Html::tag("span", "", ["class" => "glyphicon glyphicon-arrow-left"]),
                "/abiturient", ["class" => "btn btn-warning btn-lg"]) ?>
        </div>
    </div>
    <h1 align="center"><?= $this->title ?></h1>
    <div class="row">
        <div class="col-md-12">
            <?= \modules\entrant\widgets\statement\StatementRecordAndRejectionWidget::widget(['userId' => $userId, 'isDownload'=> true]); ?>
            <?= Html::a("Отправить", ['post-document/record-send'], ["class" => "btn btn-success btn-lg", 'data'=> ['method' => 'post']]) ?>
        </div>
    </div>
</div>
