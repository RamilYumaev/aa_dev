<?php
/* @var $this yii\web\View */
/* @var $model modules\entrant\forms\OtherDocumentForm */
$this->title = "Анкета. Шаг 1.1. Документ, подтверждающий принадлежность к соотечественникам за рубежом";

$this->params['breadcrumbs'][] = ['label' => 'Онлайн-регистрация', 'url' => ['default/index']];
$this->params['breadcrumbs'][] = $this->title;

use yii\helpers\Html; ?>
<div class="row">
    <div class="col-md-1">
        <?= Html::a("Назад к шагу 1", ["anketa/step1"], ["class" => "btn btn-success position-fixed mt-10"]) ?>
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