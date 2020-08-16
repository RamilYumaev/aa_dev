<?php
use yii\helpers\Html;


/* @var $test \testing\models\Test */

?>
<?= $test->introduction ?>
<?= Html::a("Начать", ['/test-attempt/start', 'test_id'=> $test->id],
    ['data' => ['confirm' => 'Вы действительно хотите начать заочный тур ?', 'method' => 'POST'],
        'class' =>'btn btn-primary'] ) ?>


