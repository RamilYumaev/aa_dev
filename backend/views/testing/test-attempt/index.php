<?php
use yii\helpers\Html;
/* @var $test testing\models\Test */
/* @var $olympic olympic\models\OlimpicList */
$this->title = "Попытки";
$this->params['breadcrumbs'][] = ['label' => \olympic\helpers\OlympicListHelper::olympicAndYearName($olympic->id),
    'url' => ['/olympic/olimpic-list/view', 'id' => $olympic->id]];
$this->params['breadcrumbs'][] = ['label' => "Tecт",
    'url' => ['/testing/test/view', 'id' => $test->id]];
$this->params['breadcrumbs'][] = $this->title;
?>
<?php if ($olympic->isFormOfPassageDistant()): ?>
    <?= Html::a("Завершить заочный тур", ['end-dist-tour','test_id'=> $test->id, 'olympic_id'=>$olympic->id], ['class'=> 'btn btn-danger'])?>
<?php endif; ?>
<div class="row">
<div class="col-md-12"><?= \backend\widgets\testing\TestAttemptWidget::widget(['test_id'=> $test->id, ]) ?></div>
</div>