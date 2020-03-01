<?php
/* @var $this yii\web\View */

$this->title = 'Онлайн-регистрация';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="container m-20">
<?= \modules\entrant\widgets\profile\ProfileWidget::widget(); ?>
<?= \modules\entrant\widgets\address\AddressWidget::widget(); ?>
<?= \modules\entrant\widgets\passport\PassportDataWidget::widget(); ?>
</div>