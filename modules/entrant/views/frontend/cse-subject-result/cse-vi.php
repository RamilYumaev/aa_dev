<?php
/* @var $this yii\web\View */
/* @var $model modules\entrant\forms\DocumentEducationForm */

$this->title = "Вступительные испытания + ЕГЭ. Утончнение.";

$this->params['breadcrumbs'][] = ['label' => 'Онлайн-регистрация', 'url' => ['default/index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="container">
    <div class="row">
        <div class="mt-20">
            <?= \modules\entrant\widgets\examinations\ExaminationsWidget::widget();?>
        </div>
    </div>
</div>

