<?php
use wbraganca\dynamicform\DynamicFormWidget;
use yii\widgets\ActiveForm;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model testing\forms\question\TestQuestionClozeForm */

$this->title = 'Редактировать "Вложенные ответы"';
$this->params['breadcrumbs'][] = ['label' => 'Вопросы"',
    'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="customer-form">
    <?php $form = ActiveForm::begin(['id' => 'dynamic-form']); ?>
    <div class="row">
        <div class="row">
            <div class="col-md-12">
                <?= $this->render('@modules/exam/views/backend/exam-question/_form-question', ['model' => $model->question, 'form' => $form, 'id'=> '']) ?>
            </div>
        </div>
        <div class="col-md-12">
            <div class="padding-v-md">
                <div class="line line-dashed"></div>
            </div>

            <?php DynamicFormWidget::begin([
                'widgetContainer' => 'dynamicform_wrapper',
                'widgetBody' => '.container-nested-items',
                'widgetItem' => '.nested-item',
                'limit' => 10,
                'min' => 1,
                'insertButton' => '.add-nested',
                'deleteButton' => '.remove-nested',
                'model' => $model->questProp[0],
                'formId' => 'dynamic-form',
                'formFields' => [
                    'name',
                    'is_start',
                    'type'
                ],
            ]); ?>
            <table class="table table-bordered table-striped">
                <thead>
                <tr>
                    <th>Вложенные ответы</th>
                    <th style="width: 450px;">Настройки вложенного ответа</th>
                    <th class="text-center" style="width: 90px;">
                        <button type="button" class="add-nested btn btn-success btn-xs"><span class="fa fa-plus"></span></button>
                    </th>
                </tr>
                </thead>
                <tbody class="container-nested-items">
                <?php foreach ($model->questProp as $index => $questProp): ?>
                    <tr class="nested-item">
                        <td class="vcenter">
                            <?= Html::activeHiddenInput($questProp, "[{$index}]id"); ?>
                            <?= $form->field($questProp, "[{$index}]name")->textInput(['maxlength' => true]) ?>
                            <?= $form->field($questProp, "[{$index}]type")->dropDownList($questProp->typeList(),
                                ['prompt' => "Выберите тип"])?>
                            <?= $form->field($questProp, "[{$index}]is_start")->checkbox() ?>
                        </td>
                        <td>
                            <?= $this->render('_form-answer-update-cloze', [
                                'form' => $form,
                                'index' => $index,
                                'modelsAnswerCloze' => $model->answerCloze[$index],
                            ]) ?>
                        </td>
                        <td class="text-center vcenter" style="width: 90px; verti">
                            <button type="button" class="remove-nested btn btn-danger btn-xs"><span class="fa fa-minus"></span></button>
                        </td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
            <?php DynamicFormWidget::end(); ?>
            </div>
        </div>
    <?= $form->field($model, "id")->hiddenInput()->label('') ?>
    <?php ActiveForm::end(); ?>
</div>
<?php
$this->registerJs(<<<JS
"use strict";
$(".dynamicform_wrapper").on("afterInsert", function(e, item) {
    item.children[0].childNodes[1].value = "";
});
JS
);
?>
