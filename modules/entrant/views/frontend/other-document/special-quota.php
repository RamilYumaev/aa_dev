<?php
/* @var $this yii\web\View */
/* @var $model modules\entrant\forms\OtherDocumentForm */
$this->title = "Документ выданный детям военнослужащих и сотрудников, поступающим на обучение в	образовательные организации,
подтверждающих право на прием в соответствии с Указом Президента РФ №268 от 09.05.2022г., федеральным органам исполнительной власти и 
федеральным государственным органам, в которых федеральным законом предусмотрена военная служба, 
федеральному органу исполнительной власти, осуществляющему функции по выработке и реализации
государственной политики и нормативно-правовому регулированию в сфере внутренних дел";

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
            <?= \modules\superservice\widgets\ButtonChangeVersionDocumentsWidgets::widget(['category'=>json_encode([4,6]), 'document' => $model->type_document, 'version' => $model->version_document])?>
            <?= $this->render('_form', ['model'=> $model] )?>

        </div>
    </div>
</div>