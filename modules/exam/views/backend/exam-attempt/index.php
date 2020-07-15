<?php

use yii\helpers\Html;
use common\sending\helpers\SendingHelper;
use common\sending\helpers\SendingDeliveryStatusHelper;
use \testing\helpers\TestAttemptHelper;

/* @var $test testing\models\Test */

$this->title = "Попытки";
$this->params['breadcrumbs'][] = ['label' => "Tecт",
    'url' => ['exam-test/view', 'id' => $test->id]];
$this->params['breadcrumbs'][] = $this->title;
?>
<?=Html::a("Подсчитать оценки незавершенных попыток", ['update-test-result', 'testId'=>$test->id], ['class'=>'btn btn-warning'])?>

<div class="row">
    <div class="col-md-12"><?= \modules\exam\widgets\exam\TestAttemptWidget::widget(['test_id' => $test->id,]) ?></div>
</div>