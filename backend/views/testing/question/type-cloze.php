<?php
use yii\helpers\Html;
use testing\helpers\TestQuestionHelper;
use yii\widgets\ActiveForm;


/* @var $this yii\web\View */
/* @var $model testing\forms\question\TestQuestionTypesForm */

\backend\assets\questions\QuestionClozeAsset::register($this);

?>
<?php $form = ActiveForm::begin(['id' => 'form-question-cloze']); ?>
<div class="row">
    <div class="col-md-12">
        <div class="box">
            <div class="box-header">
                <h4>Варианты ответов</h4>
            </div>
            <div class="box-body" id="answer-cloze-list">
                <?php for ($index = 1; $index < 2; $index++):  ?>
                    <div data-answer-index="<?= $index ?>" id="answer-cloze-type" >
                        <div class="row">
                            <h4>Вложенный ответ <?= $index ?></h4>
                            <div class="col-md-5">
                                <?= Html::beginTag('div', ['class' => 'form-group']) ?>
                                <?= Html::label("Предложение ". $index, ['class' => 'control-label']) ?>
                                <?= Html::textarea($model->formName() . "[selectAnswer][content][$index]", '', [
                                    'class' => 'form-control',
                                    'id' => 'selectanswer-contrent',
                                ]) ?>
                                <?= Html::endTag('div') ?>
                                <?= Html::beginTag('div', ['class' => 'form-group']) ?>
                                <?= Html::label("Тип вложенного ответа ". $index, ['class' => 'control-label']) ?>
                                <?= Html::dropDownList($model->formName() . "[selectAnswer][type][$index]", [], TestQuestionHelper::getAllTypeCloze(), [
                                    'class' => 'form-control',
                                    'id' => 'selectanswer-type',
                                    'prompt' => "Выберите тип"
                                ]) ?>
                                <?= Html::endTag('div') ?>
                                <?= Html::beginTag('div', ['class' => 'form-group']) ?>
                                <?= Html::checkbox($model->formName() . "[selectAnswer][start][$index]", '', [
                                    'id' => 'selectanswer-start',
                                ]) ?>
                                <?= Html::label("Вложенный ответ в начеле предложения ? ", ['class' => 'control-label']) ?>
                                <?= Html::endTag('div') ?>
                            </div>
                            <div class='col-md-7'>
                                <div class="row">
                                    <?php for ($a = 1; $a < 4; $a++):  ?>
                                        <div class="col-md-6">
                                            <?= Html::beginTag('div', ['class' => 'form-group']) ?>
                                            <?= Html::label("Ответ ". $a, ['class' => 'control-label']) ?>
                                            <?= Html::textInput($model->formName() . "[selectAnswer][text][$index][$a]", '', [
                                                'class' => 'form-control',
                                                'id' => 'selectanswer-text',
                                            ]) ?>
                                            <?= Html::endTag('div') ?>
                                        </div>
                                        <div class="col-md-6">
                                            <?= Html::beginTag('div', ['class' => 'form-group']) ?>
                                            <?= Html::label("Правильный ответ ". $a. " ? ", ['class' => 'control-label']) ?>
                                            <?= Html::dropDownList($model->formName() . "[selectAnswer][isCorrect][$index][$a]", '',
                                                 TestQuestionHelper::getAllStatusAnswer(), [
                                                'class' => 'form-control',
                                                'id' => 'selectanswer-text',
                                                    'prompt' => "Выберите правильность"
                                            ]) ?>
                                            <?= Html::endTag('div') ?>
                                        </div>
                                    <?php endfor; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endfor; ?>
            </div>
            <div class="box-footer">
                <p id="error-message" style="color: red"></p>
                <?= Html::button("Добавить вложенный ответ", [ 'id'=> 'add-answer-cloze-type', 'class' => 'btn btn-danger']) ?>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-7 center-block">
        <?= $this->render('_form-question', ['model' => $model->question, 'form' => $form, 'id'=> 'save-cloze']) ?>
    </div>
</div>
<?php ActiveForm::end(); ?>

