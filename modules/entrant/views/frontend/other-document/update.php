<?php

/* @var $this yii\web\View */
/* @var $model modules\entrant\forms\OtherDocumentForm */
use yii\helpers\Html;
$this->title = "Прочие документы. Редактирование";
$this->params['breadcrumbs'][] = ['label' => 'Персональная карточка поступающего', 'url' => ['default/index']];
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
            <?= \modules\superservice\widgets\ButtonChangeVersionDocumentsWidgets::widget(['category'=>json_encode([4,7]), 'document' => $model->type_document, 'version' => $model->version_document])?>
            <?= $this->render('_form', ['model' => $model]) ?>
        </div>
    </div>
</div>
