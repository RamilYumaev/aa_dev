<?php
use yii\helpers\Html;
\frontend\assets\modal\ModalAsset::register($this);
/* @var $this yii\web\View */
$this->title = 'Мои результаты ЕГЭ';
$this->params['breadcrumbs'][] = ['label' => 'Определение условий подачи документов', 'url' => ['/abiturient/anketa/step1']];
$this->params['breadcrumbs'][] = ['label' => 'Выбор уровня образования', 'url' => ['/abiturient/anketa/step2']];
$this->params['breadcrumbs'][] = $this->title;
$userId = Yii::$app->user->identity->getId();

?>
<div class="row">
    <div class="col-md-2">
        <?= Html::a(Html::tag("span", "", ["class" => "glyphicon glyphicon-arrow-left"])." Уровни",
            ["/abiturient/anketa/step2"], ["class" => "btn btn-warning btn-lg mt-10 ml-30"]) ?>
    </div>
</div>
<div class="container m-20">
    <p class="label label-info fs-15">После внесения всех необходимых предметов ЕГЭ, необходимо вернутся назад к выбору уровням!</p>

<?= \modules\entrant\widgets\cse\CseSubjectResultWidget::widget(['userId' => $userId]);?>

</div>