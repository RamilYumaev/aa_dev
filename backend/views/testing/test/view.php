<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\widgets\ActiveForm;


/* @var $this yii\web\View */
/* @var $test testing\models\Test */


$this->title = "Просмотр теста";
$this->params['breadcrumbs'][] = ['label' => \olympic\helpers\OlympicListHelper::olympicAndYearName($test->olimpic_id),
    'url' => ['/olympic/olimpic-list/view', 'id' => $test->olimpic_id]];
$this->params['breadcrumbs'][] = $this->title;
\backend\assets\modal\ModalAsset::register($this);

?>
<div class="row">
    <div class="col-md-12">
    <div class="box box-default">
        <div class="box box-header">
        </div>
        <div class="box-body">
            <?= DetailView::widget([
                'model' => $test,
                'attributes' => [
                    //'name'
                    ['label' => "Классы(курсы)",
                        'format'=>'raw',
                        'value' =>  \testing\helpers\TestClassHelper::TestClassString($test->id)
                    ],
                    ['label' => "Сумма баллов",
                        'format'=>'raw',
                        'value' => \testing\helpers\TestAndQuestionsHelper::markSum($test->id),
                    ],
                    ['label' => "Количество попыток",
                        'format'=>'raw',
                        'value' => Html::a(\testing\helpers\TestAttemptHelper::count($test->id), ['/testing/test-attempt/index', 'test_id' => $test->id]),
                    ],
                ],
            ]) ?>
        </div>
    </div>


<div class="box box-default">
    <?php $form = ActiveForm::begin(); ?>
    <div class="box box-header">
        <?php if($test->draft()) :?>
        <?= Html::a('Добавить вопрос', ['/testing/test-and-questions/add-question',
            'test_id'=>$test->id,], ['data-pjax' => 'w0', 'class' => 'btn btn-info', 'data-toggle' => 'modal',
            'data-modalTitle' =>'Добавить вопрос', 'data-target' => '#modal']); ?>
        <?= Html::a('Добавить группу вопросов', ['/testing/test-and-questions/add-group',
            'test_id'=>$test->id,], ['data-pjax' => 'w0', 'class' => 'btn btn-info', 'data-toggle' => 'modal',
            'data-modalTitle' =>'Добавить группу вопросов', 'data-target' => '#modal']); ?>
        <?php endif; ?>
    </div>
    <div class="box-body">
    <table class="table">
        <tr><th>#</th><th>Группа вопросов</th><th>Балл</th><th>Вопрос</th> <th></th></tr>
        <?php $a=1; foreach($testAndQuestion->arrayMark as $i=>$item): //@TODO неизвестная переменная?>
            <tr>
                <td><?= $a++; ?></td>
                <td><?= \testing\helpers\TestQuestionGroupHelper::testQuestionGroupName($item->andQuestions->test_group_id) ?? null ?></td>
                <td><?= $test->draft() ? $form->field($item,"[$i]mark")->label(false) : $item->mark; ?></td>
                <td><?=  \testing\helpers\TestQuestionHelper::questionTextName($item->andQuestions->question_id) ?? null  ?></td>
                <td><?= $test->draft() ?   Html::a('Удалить', ['/testing/test-and-questions/delete', 'id' => $item->id], ['class' => 'btn btn-danger', 'data' => ['confirm' => 'Вы уверены, что хотите удалить?',
                'method' => 'post']]) : ''?></td>
            </tr>
        <?php endforeach; ?>
    </table>
    </div>
    <div class="box-footer">
    <?= $testAndQuestion->arrayMark ?  $test->draft() ? Html::submitButton('Сохранить',['class'=>'btn btn-primary']) :"" : ""; ?>
    <?php ActiveForm::end(); ?>
</div>
</div>
    </div>
</div>