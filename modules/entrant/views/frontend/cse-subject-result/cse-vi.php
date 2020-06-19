<?php
/* @var $this yii\web\View */

use yii\helpers\Html;

/* @var $model modules\entrant\forms\DocumentEducationForm */

$this->title = "Вступительные испытания + ЕГЭ. Утончнение.";

$this->params['breadcrumbs'][] = ['label' => 'Заполнение персональной карточки поступающего', 'url' => ['/abiturient/default/index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="container">
    <div class="row">
        <div class="mt-20">
            <div class="row min-scr">
                <div class="button-left">
                    <?= Html::a(Html::tag("span", "", ["class" => "glyphicon glyphicon-arrow-left"]),
                        "/abiturient", ["class" => "btn btn-warning btn-lg"]) ?>
                </div>
            </div>
            <p>Если вы не знаете балл ЕГЭ, то введите значение 50</p>
            <?= \modules\entrant\widgets\examinations\ExaminationsWidget::widget(['userId' => $userId = Yii::$app->user->identity->getId()]);?>
        </div>
    </div>
</div>

