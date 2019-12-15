<?php
$this->title = "Попытки";
$this->params['breadcrumbs'][] = ['label' => "Tecт",
    'url' => ['/testing/test/view', 'id' => $test_id]];
//$this->params['breadcrumbs'][] = ['label' => \olympic\helpers\OlympicListHelper::olympicAndYearName($test->olimpic_id),
//    'url' => ['/olympic/olimpic-list/view', 'id' => $test->olimpic_id]];

$this->params['breadcrumbs'][] = $this->title;
?>

<div class="row">
<div class="col-md-12"><?= \backend\widgets\testing\TestAttemptWidget::widget(['test_id'=> $test_id]) ?></div>
</div>