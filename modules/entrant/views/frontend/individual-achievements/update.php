<?php

/* @var $this yii\web\View */
/* @var $model modules\entrant\forms\OtherDocumentForm */
use yii\helpers\Html;
$this->title = "Доступные индивидуальные достижения. Редактирование документа.";

$this->params['breadcrumbs'][] = ['label' => 'Персональная карточка поступающего', 'url' => ['default/index']];
$this->params['breadcrumbs'][] = ['label' => 'Доступные индивидуальные достижения', 'url' => ['individual-achievements/index']];
$this->params['breadcrumbs'][] = $this->title; ?>

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
            <?= \modules\superservice\widgets\ButtonChangeVersionDocumentsWidgets::widget(['category'=> json_encode([7,3,4,5,6]), 'document' => $model->type_document, 'version' => $model->version_document])?>
            <?= $this->render('@modules/entrant/views/frontend/other-document/_form', ['model' => $model]) ?>
        </div>
    </div>
</div>
