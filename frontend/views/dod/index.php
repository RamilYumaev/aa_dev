<?php
use frontend\widgets\dod\DodWidget;
$this->title = 'Дни открытых дверей';
$this->params['breadcrumbs'][] = $this->title;
?>
<?= DodWidget::widget(['type'=> \dod\helpers\DodHelper::SHARE_YES, 'view'=> 'dod/index-share']); ?>
<?= DodWidget::widget(['type'=> \dod\helpers\DodHelper::SHARE_NO, 'view'=> 'dod/index-no-share']); ?>

