<?php
/* @var $this yii\web\View */
/* @var $model modules\entrant\forms\OtherDocumentForm */
$this->title = "Заключение об отсутствии противопоказаний для обучения (медицинская справка 086у; действующая медицинская книжка)";

$this->params['breadcrumbs'][] = ['label' => 'Определение условий подачи документов', 'url' => ['/abiturient/anketa/step1']];
$this->params['breadcrumbs'][] = ['label' => 'Персональная карточка поступающего', 'url' => ['default/index']];
$this->params['breadcrumbs'][] = $this->title;

use yii\helpers\Html; ?>
<div class="row">
    <div class="col-md-1">
        <?= Html::a(Html::tag("span", "", ["class" => "glyphicon glyphicon-arrow-left"]),
            ['default/index'], ["class" => "btn btn-success position-fixed mt-10 ml-30"]) ?>
    </div>
</div>
<div class="container">
    <div class="row">
        <div class="col-md-12 mt-30">
            <h1><?= Html::encode($this->title) ?></h1>
            <?= $this->render('_form', ['model'=> $model] )?>
        </div>
    </div>
</div>