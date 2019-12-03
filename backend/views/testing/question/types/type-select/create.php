<?php
use yii\helpers\Html;
use wbraganca\dynamicform\DynamicFormWidget;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model testing\forms\question\TestQuestionTypesForm */
/* @var $model->question  testing\forms\question\TestQuestionForm */
/* @var $model->answer  testing\forms\question\TestAnswerForm */

\backend\assets\questions\QuestionSelectTypeAsset::register($this);
$this->title = 'Создать "Вариант(ы)"';
$olympic_id = Yii::$app->request->get('olympic_id');
$this->params['breadcrumbs'][] = ['label' => 'Олимпиады/конкурсы', 'url' => ['olympic/olympic/index']];
$this->params['breadcrumbs'][] = ['label' => \olympic\helpers\OlympicHelper::olympicName($olympic_id),
    'url' => ['olympic/olympic/view', 'id'=> $olympic_id]];
$this->params['breadcrumbs'][] = ['label' => 'Банк вопросов "Вариант(ы)"',
    'url' => ['index', 'olympic_id'=> $olympic_id]];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="row">
    <div class="customer-form">
        <?php $form = ActiveForm::begin(['id' => 'dynamic-form']); ?>
        <div class="col-md-7">
            <?= $this->renderFile('@backend/views/testing/question/_form-question.php',
              ['model' => $model->question, 'form' => $form, 'id'=> 'save-answer-select-type' ])?>
        </div>
        <div class="col-md-5">
            <div class="padding-v-md">
                <div class="line line-dashed"></div>
            </div>
            <?php DynamicFormWidget::begin([
                'widgetContainer' => 'dynamicform_wrapper', // required: only alphanumeric characters plus "_" [A-Za-z0-9_]
                'widgetBody' => '.container-items', // required: css class selector
                'widgetItem' => '.item', // required: css class
                'limit' => 10, // the maximum times, an element can be cloned (default 999)
                'min' => 1, // 0 or 1 (default 1)
                'insertButton' => '.add-item', // css class
                'deleteButton' => '.remove-item', // css class
                'model' => $model->answer[0],
                'formId' => 'dynamic-form',
                'formFields' => [
                    'name',
                    'is_correct',
                ],
            ]); ?>
            <div class="panel panel-default">
                <div class="panel-heading">
                    <i class="fa fa-question"></i> Варианты
                    <button type="button" class="pull-right add-item btn btn-success btn-xs"><i class="fa fa-plus"></i> Добавить еще вариант</button>
                    <div class="clearfix"></div>
                </div>
                <div class="panel-body container-items"><!-- widgetContainer -->
                    <?php foreach ($model->answer as $index => $answer): ?>
                    <div class="item panel panel-default"><!-- widgetBody -->
                        <div class="panel-heading">
                            <span class="panel-title-address">Вариант ответа: <?= ($index + 1) ?></span>
                            <button type="button" class="pull-right remove-item btn btn-danger btn-xs"><i class="fa fa-minus"></i></button>
                            <div class="clearfix"></div>
                        </div>
                        <div class="panel-body">
                            <?= $form->field($answer, "[{$index}]name")->textInput(['maxlength' => true]) ?>
                            <?= $form->field($answer, "[{$index}]is_correct")->checkbox() ?>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
                <?php DynamicFormWidget::end(); ?>
            </div>
        </div>
        <?= $form->field($model, "id")->hiddenInput()->label('') ?>
        <?php ActiveForm::end(); ?>
    </div>
</div>

