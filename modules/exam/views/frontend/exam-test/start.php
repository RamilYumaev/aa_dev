<?php
use yii\helpers\Html;


/* @var $test \modules\exam\models\ExamTest */

?>
<?= $test->introduction ?>
<?= Html::a("Начать", ['exam-attempt/start', 'test_id'=> $test->id],
    ['data' => ['confirm' => 'Вы действительно хотите начать экзамен?', 'method' => 'POST'],
        'class' =>'btn btn-primary'] ) ?>


