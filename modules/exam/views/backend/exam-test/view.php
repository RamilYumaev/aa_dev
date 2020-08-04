<?php

use entrant\assets\modal\ModalAsset;
use modules\exam\helpers\ExamAttemptHelper;
use modules\exam\helpers\ExamQuestionInTestHelper;
use modules\exam\helpers\ExamStatementHelper;
use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $test modules\exam\models\ExamTest*/
/* @var $examQuestionInTest modules\exam\forms\ExamQuestionInTestTableMarkForm */


$this->title = "Просмотр теста";
$this->params['breadcrumbs'][] = ['label' => "Экзамены", 'url' => ['exam/index']];
$this->params['breadcrumbs'][] = ['label' => "Экзамен. ".$test->exam->discipline->name, 'url' => ['exam/view',
    'id' => $test->exam_id]];
$this->params['breadcrumbs'][] = $this->title;
ModalAsset::register($this);
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
                        'name',
                    ['label' => "Сумма баллов",
                        'format'=>'raw',
                        'value' => ExamQuestionInTestHelper::markSum($test->id),
                    ],
                    ['label' => "Количество попыток",
                        'format'=>'raw',
                        'value' => $test->getAttempt()->count(),
                    ],
                    ['label' => "Количество попыток (". ExamStatementHelper::listTypes()[ExamStatementHelper::USUAL_TYPE_OCH].')',
                        'format'=>'raw',
                        'value' => Html::a($test->getCountAttempt(ExamStatementHelper::USUAL_TYPE_OCH), ['exam-attempt/index', 'test_id' => $test->id, 'type'=> ExamStatementHelper::USUAL_TYPE_OCH ])." "
                        .Html::a("Экспорт в АИС", ['communication/export-data', 'examId' => $test->exam_id, 'type'=>ExamStatementHelper::USUAL_TYPE_OCH], ['data-method' => 'post', 'class' => 'btn btn-success'])." "
                        .Html::a("json", ['communication/json-data', 'examId' => $test->exam_id, 'type'=>ExamStatementHelper::USUAL_TYPE_OCH], ['data-method' => 'post', 'class' => 'btn btn-warning'])." ",
                    ],
                    ['label' => "Количество попыток (". ExamStatementHelper::listTypes()[ExamStatementHelper::USUAL_TYPE_ZA_OCH].')',
                        'format'=>'raw',
                        'value' => Html::a($test->getCountAttempt(ExamStatementHelper::USUAL_TYPE_ZA_OCH), ['exam-attempt/index', 'test_id' => $test->id, 'type'=> ExamStatementHelper::USUAL_TYPE_ZA_OCH ])." "
                            .Html::a("Экспорт в АИС", ['communication/export-data', 'examId' => $test->exam_id, 'type'=>ExamStatementHelper::USUAL_TYPE_ZA_OCH], ['data-method' => 'post', 'class' => 'btn btn-success'])." "
                            .Html::a("json", ['communication/json-data', 'examId' => $test->exam_id, 'type'=>ExamStatementHelper::USUAL_TYPE_ZA_OCH], ['data-method' => 'post', 'class' => 'btn btn-warning'])." ",
                    ],
                    ['label' => "Количество попыток (". ExamStatementHelper::listTypes()[ExamStatementHelper::RESERVE_TYPE].')',
                        'format'=>'raw',
                        'value' => Html::a($test->getCountAttempt(ExamStatementHelper::RESERVE_TYPE), ['exam-attempt/index', 'test_id' => $test->id, 'type'=> ExamStatementHelper::RESERVE_TYPE ])." "
                            .Html::a("Экспорт в АИС", ['communication/export-data', 'examId' => $test->exam_id, 'type'=>ExamStatementHelper::RESERVE_TYPE], ['data-method' => 'post', 'class' => 'btn btn-success'])." "
                         .Html::a("json", ['communication/json-data', 'examId' => $test->exam_id, 'type'=>ExamStatementHelper::RESERVE_TYPE], ['data-method' => 'post', 'class' => 'btn btn-warning'])." ",
                    ],
                ],
            ]) ?>
        </div>
    </div>


<div class="box box-default">
    <?php $form = ActiveForm::begin(); ?>
    <div class="box box-header">
        <?php if($test->draft()) :?>
        <?= Yii::$app->user->can("oneQuestion") ? Html::a('Добавить вопрос', ['exam-question-in-test/add-question',
            'test_id'=>$test->id,], ['data-pjax' => 'w7', 'class' => 'btn btn-info', 'data-toggle' => 'modal',
            'data-modalTitle' =>'Добавить вопрос', 'data-target' => '#modal']) : ""; ?>
        <?= Html::a('Добавить группу вопросов', ['exam-question-in-test/add-group',
            'test_id'=>$test->id,], ['data-pjax' => 'w6', 'class' => 'btn btn-info', 'data-toggle' => 'modal',
            'data-modalTitle' =>'Добавить группу вопросов', 'data-target' => '#modal']); ?>
        <?php endif; ?>
    </div>
    <div class="box-body">
    <table class="table">
        <tr><th>#</th><th>Группа вопросов</th><th>Балл</th><th>Вопрос</th> <th></th></tr>
        <?php $a=1; foreach($examQuestionInTest->arrayMark as $i=>$item):?>
            <tr>
                <td><?= $a++;?></td>
                <td><?= $item->examQuestionInTest->questionGroup->name ?? null ?></td>
                <td><?= $test->draft() ? $form->field($item,"[$i]mark")->label(false) : $item->mark; ?></td>
                <td><?=  $item->examQuestionInTest->question->text ?? null  ?></td>
                <td><?= $test->draft() ?   Html::a('Удалить', ['exam-question-in-test/delete', 'id' => $item->id], ['class' => 'btn btn-danger', 'data' => ['confirm' => 'Вы уверены, что хотите удалить?',
                'method' => 'post']]) : ''?></td>
            </tr>
        <?php endforeach; ?>
    </table>
    </div>
    <div class="box-footer">
    <?= $examQuestionInTest->arrayMark ?  $test->draft() ? Html::submitButton('Сохранить',['class'=>'btn btn-primary']) :"" : ""; ?>
    <?php ActiveForm::end(); ?>
</div>
</div>
    </div>
</div>