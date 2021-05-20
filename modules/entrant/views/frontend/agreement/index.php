<?php
/* @var $this yii\web\View */
/* @var $model modules\entrant\forms\AgreementForm */
/* @var $agreement modules\entrant\models\Agreement */

$this->title = "Договор о целевом обучении. ". ($agreement ? "Редактирование": "Добавление").".";
$this->params['breadcrumbs'][] = ['label' => 'Определение условий подачи документов', 'url' => ['/abiturient/anketa/step1']];
$this->params['breadcrumbs'][] = $this->title;
use yii\helpers\Html; ?>
<div class="row">
    <div class="col-md-1">
        <?= Html::a(Html::tag("span", "", ["class" => "glyphicon glyphicon-arrow-left"]),
            ["anketa/step2"], ["class" => "btn btn-success position-fixed btn-lg mt-10 ml-30"]) ?>
    </div>
</div>
<?= $this->render('_form', ['model'=> $model] )?>

