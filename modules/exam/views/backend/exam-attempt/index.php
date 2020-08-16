<?php

use modules\exam\helpers\ExamStatementHelper;
use yii\helpers\Html;
use common\sending\helpers\SendingHelper;
use common\sending\helpers\SendingDeliveryStatusHelper;
use \testing\helpers\TestAttemptHelper;

/* @var $test \modules\exam\models\ExamTest */
/* @var $type integer */
$d =ExamStatementHelper::listTypes();
$this->title = "Попытки ". (key_exists($type, $d) ? $d[$type] : "");
$this->params['breadcrumbs'][] = ['label' => "Экзамены", 'url' => ['exam/index']];
$this->params['breadcrumbs'][] = ['label' => "Экзамен. ".$test->exam->discipline->name, 'url' => ['exam/view',
    'id' => $test->exam_id]];
$this->params['breadcrumbs'][] = ['label' => $test->name,
    'url' => ['exam-test/view', 'id' => $test->id]];
$this->params['breadcrumbs'][] = $this->title;
?>
<?=Html::a("Подсчитать оценки незавершенных попыток", ['update-test-result', 'testId'=>$test->id], ['class'=>'btn btn-warning'])?>

<div class="row">
    <div class="col-md-12"><?= \modules\exam\widgets\exam\TestAttemptWidget::widget(['test_id' => $test->id, 'type' => $type ]) ?></div>
</div>