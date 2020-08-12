<?php
/* @var $this yii\web\View */

use yii\helpers\Html;

\frontend\assets\modal\ModalAsset::register($this);

$this->title = 'Договор об оказании платных образовательных услуг. Загрузка файлов';

$this->params['breadcrumbs'][] = ['label' => 'Определение условий подачи документов', 'url' => ['/abiturient/anketa/step1']];
$this->params['breadcrumbs'][] = ['label' => 'Выбор уровня образования', 'url' => ['/abiturient/anketa/step2']];
$this->params['breadcrumbs'][] = ['label' => 'Заполнение персональной карточки поступающего', 'url' => ['/abiturient/default/index']];
$this->params['breadcrumbs'][] = $this->title;

$userId = Yii::$app->user->identity->getId();
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
            <div class="text-danger fs-15">
<p>Внимательно ознакомьтесь с условиями договора и проверьте введённые вами данные в преамбуле договора и п.8.
    После отправки договора, редактирование данных НЕДОСТУПНО!</p>
<p>Договор подписывается в пункте 8 (под Вашими паспортными данными) и ниже, в соответствующем поле.
    Также, необходимо визировать каждую страницу договора (поставить подпись в правом нижнем углу).</p>
<p>В случае возникновения вопросов в рамках заключения договора об оказании платных образовательных услуг
    обращайтесь по тел. 8(495)438-18-57 или на многоканальный телефон Приемной комиссии МПГУ - 8(499)702-41-41</p>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <p class="text-center"><?=Html::a('Образец договора об оказании платных образовательных услуг',
                            "@frontendInfo/documents/obrazec.pdf", ['target'=> "_blank"])?></p>
                </div>
            </div>
            <?= \modules\entrant\widgets\statement\StatementCgContractWidget::widget(['userId' => $userId]); ?>
        </div>
    </div>
    <div class="row">
        <div class="col-md-4 col-md-offset-4">
            <?= Html::a("Отправить в приемную комиссию", ['post-document/send'], ["class" => "btn btn-success btn-lg", 'data' => ['method' => 'post']]) ?>
        </div>
    </div>
</div>
</div>
</div>
</div>
