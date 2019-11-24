<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use mihaildev\ckeditor\CKEditor;
use mihaildev\elfinder\ElFinder;

/* @var $this yii\web\View */
/* @var $model testing\forms\question\TestQuestionTypesForm */

\backend\assets\questions\QuestionSelectTypeOneAsset::register($this);
?>
<div class="row">
<?php $form = ActiveForm::begin(['id' => 'form-question-select-type-one']); ?>
    <div class="col-md-7">
        <?= $this->render('_form-question', ['model' => $model->question, 'form' => $form, 'id'=> 'save-answer-select-type-one']) ?>
    </div>
    <div class="col-md-5">
        <div class="box">
            <div class="box-header">
                <h4>Варианты ответов</h4>
            </div>
            <div class="box-body" id="answer-select-type-one-list">
                <?php for ($index = 1; $index < 3; $index++):  ?>
                    <div data-answer-index="<?= $index ?>" id="answer-select-type-one" >
                        <?= Html::beginTag('div', ['class' => 'form-group']) ?>
                        <?= Html::label("Вариант ответа ". $index, ['class' => 'control-label']) ?>
                        <?= Html::textInput($model->formName() . '[selectAnswer][text][]', '', [
                            'class' => 'form-control',
                            'id' => 'selectanswer-text',
                        ]) ?>
                        <?= Html::endTag('div') ?>
                        <?= Html::beginTag('div', ['class' => 'form-group']) ?>
                        <?= Html::checkbox($model->formName() . '[selectAnswer][isCorrect][]', '', [
                            'id' => 'selectanswer-iscorrect',
                        ]) ?>
                        <?= Html::label("Правильный ответ ? ", ['class' => 'control-label']) ?>
                        <?= Html::endTag('div') ?>
                    </div>
                <?php endfor; ?>
            </div>
            <div class="box-footer">
                <p id="error-message" style="color: red"></p>
                <?= Html::button("Добавить  вариант ответа", [ 'id'=> 'add-answer-select-type-one', 'class' => 'btn btn-danger']) ?>
            </div>
        </div>
    </div>

<?php ActiveForm::end(); ?>
    </div>
