<?php
use yii\helpers\Html;
use wbraganca\dynamicform\DynamicFormWidget;
?>
<?php DynamicFormWidget::begin([
    'widgetContainer' => 'dynamicform_inner',
    'widgetBody' => '.container-answer-nested',
    'widgetItem' => '.answer-item',
    'limit' => 5,
    'min' => 1,
    'insertButton' => '.add-answer-nested',
    'deleteButton' => '.remove-answer-nested',
    'model' => $modelsAnswerCloze[0],
    'formId' => 'dynamic-form',
    'formFields' => [
            'id',
        'name',
        'is_correct'
    ],
]); ?>
    <table class="table table-bordered">
        <thead>
        <tr>
            <th>Ответы</th>
            <th class="text-center">
                <button type="button" class="add-answer-nested btn btn-success btn-xs"><span class="glyphicon glyphicon-plus"></span></button>
            </th>
        </tr>
        </thead>
        <tbody class="container-answer-nested">
        <?php foreach ($modelsAnswerCloze as $indexAnswer => $answerCloze): ?>
            <tr class="answer-item">
                <td class="vcenter">
                    <?= Html::activeHiddenInput($answerCloze, "[{$index}][{$indexAnswer}]id"); ?>
                    <?= $form->field($answerCloze, "[{$index}][{$indexAnswer}]name")->label(false)->textInput(['maxlength' => true]) ?>
                    <?= $form->field($answerCloze, "[{$index}][{$indexAnswer}]is_correct")->checkbox() ?>
                </td>
                <td class="text-center vcenter" style="width: 90px;">
                    <button type="button" class="remove-answer-nested btn btn-danger btn-xs"><span class="glyphicon glyphicon-minus"></span></button>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
<?php DynamicFormWidget::end(); ?>
<?php
$this->registerJs(<<<JS
"use strict";
$(".dynamicform_inner").on("afterInsert", function(e, item) {
    item.children[0].childNodes[1].value = "";
});
JS
);
?>

