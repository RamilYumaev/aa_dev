<?php
/* @var $this yii\web\View */
/* @var $model modules\entrant\forms\OtherDocumentForm */
$this->title = "Преимущественное право. Добавление документа.";

$this->params['breadcrumbs'][] = ['label' => 'Персональная карточка поступающего', 'url' => ['default/index']];
$this->params['breadcrumbs'][] = ['label' => 'Преимущественное право', 'url' => ['preemptive-right/index']];
$this->params['breadcrumbs'][] = $this->title;

use yii\helpers\Html; ?>

<div class="row min-scr">
    <div class="button-left">
        <?= Html::a(Html::tag("span", "", ["class" => "glyphicon glyphicon-arrow-left"]),
            "/abiturient", ["class" => "btn btn-warning btn-lg"]) ?>
    </div>
</div>
<div class="container">
    <div class="row">
        <div class="col-md-12 mt-30">
            <h1><?= Html::encode($this->title) ?></h1>
            <?= \modules\superservice\widgets\ButtonChangeVersionDocumentsWidgets::widget(['category'=> json_encode([4,5,6]),'document' => '', 'version' =>  ''])?>
            <?= $this->render('@modules/entrant/views/frontend/other-document/_form', ['model'=> $model] )?>
        </div>
    </div>
</div>