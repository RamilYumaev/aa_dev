<?php
/* @var $this yii\web\View */
/* @var $model modules\entrant\forms\AgreementForm */
$this->title = "Анкета. Шаг 1.1. Договор. Добавление.";
$this->params['breadcrumbs'][] = ['label' => 'Онлайн-регистрация', 'url' => ['default/index']];
$this->params['breadcrumbs'][] = $this->title;
use yii\helpers\Html; ?>
<div class="row">
    <div class="col-md-1">
        <?= Html::a("Назад к шагу 1", ["anketa/step1"], ["class" => "btn btn-success position-fixed mt-10"]) ?>
    </div>
</div>
<?= $this->render('_form', ['model'=> $model] )?>

