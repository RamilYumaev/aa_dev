<?php
use yii\helpers\Html;
use wbraganca\dynamicform\DynamicFormWidget;
?>
<?php DynamicFormWidget::begin([
    'widgetContainer' => 'dynamicform_inner',
    'widgetBody' => '.container-answer-cloze',
    'widgetItem' => '.room-item',
    'limit' => 5,
    'min' => 1,
    'insertButton' => '.add-answer-cloze',
    'deleteButton' => '.remove-answer-cloze',
    'model' => $modelsAnswerCloze[0],
    'formId' => 'dynamic-form',
    'formFields' => [
        'name',
        'is_correct'
    ],
]); ?>
    <table class="table table-bordered">
        <thead>
        <tr>
            <th>Ответы</th>
            <th class="text-center">
                <button type="button" class="add-answer-cloze btn btn-success btn-xs"><span class="glyphicon glyphicon-plus"></span></button>
            </th>
        </tr>
        </thead>
        <tbody class="container-answer-cloze">
        <?php foreach ($modelsAnswerCloze as $indexAnswer => $answerCloze): ?>
            <tr class="room-item">
                <td class="vcenter">
                    <?= $form->field($answerCloze, "[{$index}][{$indexAnswer}]name")->label(false)->textInput(['maxlength' => true]) ?>
                    <?= $form->field($answerCloze, "[{$index}][{$indexAnswer}]is_correct")->dropDownList(['Нет', 'Да']) ?>
                </td>
                <td class="text-center vcenter" style="width: 90px;">
                    <button type="button" class="remove-answer-cloze btn btn-danger btn-xs"><span class="glyphicon glyphicon-minus"></span></button>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
<?php DynamicFormWidget::end(); ?>