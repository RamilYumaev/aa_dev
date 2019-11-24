<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use mihaildev\ckeditor\CKEditor;
use mihaildev\elfinder\ElFinder;

/* @var $this yii\web\View */
/* @var $model testing\forms\question\TestQuestionTypesForm */

\backend\assets\questions\QuestionMatchingAsset::register($this);

?>
<div class="row">
<?php $form = ActiveForm::begin(['id' => 'form-question-matching']); ?>
    <div class="col-md-6">
        <div class="box">
            <div class="box-header">
                <h4>Варианты ответов</h4>
            </div>
            <div class="box-body" id="answer-matching-list">
                <?php for ($index = 1; $index < 3; $index++):  ?>
                    <div data-answer-index="<?= $index ?>" id="answer-matching" >
                        <div class="row">
                            <div class="col-md-6">
                                <?= Html::beginTag('div', ['class' => 'form-group']) ?>
                                <?= Html::label("Вопрос ". $index, ['class' => 'control-label']) ?>
                                <?= Html::textInput($model->formName() . '[selectAnswer][text][]', '', [
                                    'class' => 'form-control',
                                    'id' => 'selectanswer-text',
                                ]) ?>
                                <?= Html::endTag('div') ?>
                            </div>
                            <div class="col-md-6">
                                <?= Html::beginTag('div', ['class' => 'form-group']) ?>
                                <?= Html::label("Ответ ". $index, ['class' => 'control-label']) ?>
                                <?= Html::textInput($model->formName() . '[selectAnswer][isCorrect][]', '', [
                                    'class' => 'form-control',
                                    'id' => 'selectanswer-text',
                                ]) ?>
                                <?= Html::endTag('div') ?>
                            </div>
                        </div>
                    </div>
                <?php endfor; ?>
            </div>
            <div class="box-footer">
                <p id="error-message" style="color: red"></p>
                <?= Html::button("Добавить сопаставление", [ 'id'=> 'add-answer-matching', 'class' => 'btn btn-success']) ?>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <?= $this->render('_form-question', ['model' => $model->question, 'form' => $form, 'id'=> 'save-matching']) ?>
    </div>
<?php ActiveForm::end(); ?>
</div>
