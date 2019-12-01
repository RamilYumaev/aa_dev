<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\widgets\ActiveForm;


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
                    ],
                    ['label' => "Сумма баллов",
                        'format'=>'raw',
                        'value' => \testing\helpers\TestAndQuestionsHelper::markSum($test->id),
                    ],
                ],
            ]) ?>
        </div>
    </div>


<div class="box box-default">
    <?php $form = ActiveForm::begin(); ?>
    <div class="box box-header">
        <?= Html::a('Добвить вопрос', ['/testing/test-and-questions/add-question',
            'test_id'=>$test->id,], ['data-pjax' => 'w0', 'class' => 'btn btn-info', 'data-toggle' => 'modal',
            'data-modalTitle' =>'Добавить вопрос', 'target' => '#modal']); ?>
        <?= Html::a('Добавить группу вопросов', ['/testing/test-and-questions/add-group',
            'test_id'=>$test->id,], ['data-pjax' => 'w0', 'class' => 'btn btn-info', 'data-toggle' => 'modal',
            'data-modalTitle' =>'Добавить группу вопросов', 'target' => '#modal']); ?>
    </div>
    <div class="box-body">
    <table class="table">
        <tr><th>#</th><th>Группа вопросов</th><th>Балл</th><th>Вопрос</th> <th></th></tr>
        <?php $a=1; foreach($testAndQuestion->arrayMark as $i=>$item): ?>
            <tr>
                <td><?= $a++; ?></td>
                <td><?= \testing\helpers\TestQuestionGroupHelper::testQuestionGroupName($item->andQuestions->test_group_id) ?? null ?></td>
                <td><?= $form->field($item,"[$i]mark")->label(false); ?></td>
                <td><?=  \testing\helpers\TestQuestionHelper::questionTextName($item->andQuestions->question_id) ?? null  ?></td>
                <td><?=   Html::a('Удалить', ['/testing/test-and-questions/delete', 'id' => $item->id], ['class' => 'btn btn-danger', 'data' => ['confirm' => 'Вы уверены, что хотите удалить?',
                'method' => 'post']]) ?></td>
            </tr>
        <?php endforeach; ?>
    </table>
    </div>
    <div class="box-footer">
    <?= $testAndQuestion->arrayMark ?  Html::submitButton('Сохранить',['class'=>'btn btn-primary']) : ""; ?>
    <?php ActiveForm::end(); ?>
</div>
</div>