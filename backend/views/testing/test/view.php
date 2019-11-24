<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $test testing\models\Test */

$this->title = "Просмотр";
$this->params['breadcrumbs'][] = ['label' => 'Тесты', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\backend\assets\modal\ModalAsset::register($this);
?>

    <div class="box box-default">
        <div class="box box-header">
        </div>
        <div class="box-body">
            <?= DetailView::widget([
                'model' => $test,
                'attributes' => [
                    //'name',
                    ['label' => "Олимпиада",
                        'format'=>'raw',
                        'value' =>
                            Html::a(\olympic\helpers\OlympicListHelper::olympicAndYearName($test->olimpic_id),
                                ['/olympic/olimpic-list/view', 'id' => $test->olimpic_id])
                    ],
                    ['label' => "Классы(курсы)",
                        'format'=>'raw',
                        'value' =>  \testing\helpers\TestClassHelper::TestClassString($test->id)
                    ]
                ],
            ]) ?>
        </div>
    </div>
<?= \backend\widgets\testing\TestQuestionWidget::widget(['test_id' => $test->id]) ?>
