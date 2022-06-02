<?php
/* @var $this yii\web\View */
/* @var $model modules\entrant\forms\OtherDocumentForm */
$this->title = "Документ, подтверждающий принадлежность к категориям особой квоты";

$this->params['breadcrumbs'][] = ['label' => 'Определение условий подачи документов', 'url' => ['/abiturient/anketa/step1']];
$this->params['breadcrumbs'][] = $this->title;

use yii\helpers\Html; ?>
<div class="row">
    <div class="col-md-1">
        <?= Html::a(Html::tag("span", "", ["class" => "glyphicon glyphicon-arrow-left"]),
            ["anketa/step1"], ["class" => "btn btn-success btn-lg position-fixed mt-10 ml-30"]) ?>
    </div>
</div>
<div class="container">
    <div class="row">
        <div class="col-md-12 mt-30">
            <h1><?= Html::encode($this->title) ?></h1>
            <?= \modules\superservice\widgets\ButtonChangeVersionDocumentsWidgets::widget(['category'=>json_encode([4]), 'document' => '', 'version' =>  ''])?>
            <?= $this->render('_form', ['model'=> $model] )?>

        </div>
    </div>
</div>