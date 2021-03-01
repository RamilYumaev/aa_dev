<?php
/* @var $model modules\management\forms\TaskForm */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $schedule modules\management\models\Schedule*/
/* @var $this yii\web\View */

use backend\assets\modal\ModalAsset;
use kartik\date\DatePicker;
use kartik\select2\Select2;
use mihaildev\ckeditor\CKEditor;
use mihaildev\elfinder\ElFinder;
use modules\management\models\DictTask;
use modules\management\models\ManagementUser;
use modules\management\models\Schedule;
use yii\bootstrap\ActiveForm;
use yii\helpers\Html;

?>

<div class="box">
    <div class="box-body">
        <?php $form = ActiveForm::begin(['id'=> 'form-dict-task']); ?>
        <div class="row">
            <div class="col-md-7">
                <?= $form->field($model, 'director_user_id')->widget(Select2::class, [
                    'data' => ManagementUser::find()->allColumn(),
                    'options' => ['placeholder' => 'Выберите постановщика'],
                    'pluginOptions' => ['allowClear' => true],
                ]);?>
                <?= $form->field($model, 'dict_task_id')->widget(Select2::class, [
                    'data' =>DictTask::find()->allColumnUser($model->responsible_user_id, 'description'),
                    'options' => ['placeholder' => 'Выберите функцию/задачу'],
                    'pluginOptions' => ['allowClear' => true],
                ]);?>
                <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>
                <?= $form->field($model, 'text')->widget(CKEditor::class, [
                    'editorOptions' => ElFinder::ckeditorOptions('elfinder', ['filter' => 'flash']),
                ]); ?>
            </div>
            <div class="col-md-5">
                <?= $this->render('_work', ['schedule'=> $schedule]) ?>
                <?= $form->field($model, 'date_end')->textInput(['readonly'=> true]); ?>

                <?= $form->field($model, 'position')->textInput(['maxlength' => true]) ?>
            </div>
        </div>
        <div class="form-group">
            <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
        </div>
        <?php ActiveForm::end(); ?>
    </div>
</div>
