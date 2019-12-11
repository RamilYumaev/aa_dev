<?php
use wbraganca\dynamicform\DynamicFormWidget;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model testing\forms\question\TestQuestionClozeForm */

$this->title = 'Создать "Вложенные ответы"';
$olympic_id = Yii::$app->request->get('olympic_id');
$this->params['breadcrumbs'][] = ['label' => 'Олимпиады/конкурсы', 'url' => ['olympic/olympic/index']];
$this->params['breadcrumbs'][] = ['label' => \olympic\helpers\OlympicHelper::olympicName($olympic_id),
    'url' => ['olympic/olympic/view', 'id'=> $olympic_id]];
$this->params['breadcrumbs'][] = ['label' => 'Вопросы теста "Вложенные ответы"',
    'url' => ['index', 'olympic_id'=> $olympic_id]];
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="customer-form">
    <?php $form = ActiveForm::begin(['id' => 'dynamic-form']); ?>
    <div class="row">
        <div class="col-md-12">
            <?= $this->render('@backend/views/testing/question/_form-question', ['model' => $model->question, 'form' => $form, 'id'=> '']) ?>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="padding-v-md">
                <div class="line line-dashed"></div>
            </div>

            <?php DynamicFormWidget::begin([
                'widgetContainer' => 'dynamicform_wrapper',
                'widgetBody' => '.container-items',
                'widgetItem' => '.cloze-item',
                'limit' => 10,
                'min' => 1,
                'insertButton' => '.add-cloze',
                'deleteButton' => '.remove-cloze',
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
                        <button type="button" class="add-cloze btn btn-success btn-xs"><span class="fa fa-plus"></span></button>
                    </th>
                </tr>
                </thead>
                <tbody class="container-items">
                <?php foreach ($model->questProp as $index => $questProp): ?>
                    <tr class="cloze-item">
                        <td class="vcenter">
                            <?= $form->field($questProp, "[{$index}]name")->textInput(['maxlength' => true]) ?>
                            <?= $form->field($questProp, "[{$index}]type")->dropDownList($questProp->typeList(),
                                ['prompt' => "Выберите тип"])?>
                            <?= $form->field($questProp, "[{$index}]is_start")->checkbox() ?>
                        </td>
                        <td>
                            <?= $this->render('_form-answer-cloze', [
                                'form' => $form,
                                'index' => $index,
                                'modelsAnswerCloze' => $model->answerCloze[$index],
                            ]) ?>
                        </td>
                        <td class="text-center vcenter" style="width: 90px; verti">
                            <button type="button" class="remove-cloze btn btn-danger btn-xs"><span class="fa fa-minus"></span></button>
                        </td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
            <?php DynamicFormWidget::end(); ?>
            </div>
        </div>
    </div>

    <?= $form->field($model, "id")->hiddenInput()->label('') ?>
    <?php ActiveForm::end(); ?>
</div>


