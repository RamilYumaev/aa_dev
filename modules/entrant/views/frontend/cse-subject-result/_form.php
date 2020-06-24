<?php

/* @var $model modules\entrant\forms\CseSubjectResultForm */
/* @var $isKeys array */
/* @var $form yii\bootstrap\ActiveForm */

use yii\bootstrap\ActiveForm;
use yii\helpers\Html;
use wbraganca\dynamicform\DynamicFormWidget;
use modules\dictionary\helpers\DictCseSubjectHelper;
\modules\entrant\assets\cse\CseSubjectResultAsset::register($this);

?>
<div class="container">
    <div class="row">
        <div class="col-md-12 mt-30">
            <h1><?= Html::encode($this->title) ?></h1>
            <p class="label label-warning fs-15" align="justify">Если Вы не знаете балл ЕГЭ, то введите значение 50.<br/>
                Ваши баллы будут проверены в Федеральной информационной системе, <br/>автоматически исправлены и опубликованы
                в списках поступающих <br/>на официальном сайте МПГУ http://mpgu.su</p>
            <?php $form = ActiveForm::begin(['id'=> 'form-cse-subject']); ?>
            <?= $form->field($model, 'year')->textInput(['maxlength' => true]) ?>
            <div class="col-md-12">
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
                    'model' => $model->resultData[0],
                    'formId' => 'form-cse-subject',
                    'formFields' => [
                        'subject_id',
                        'mark',
                    ],
                ]); ?>
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <i class="fa fa-question"></i> Результаты ЕГЭ
                        <button type="button" class="pull-right add-item btn btn-success btn-xs"><i class="fa fa-plus"></i> Добавить еще предмет</button>
                        <div class="clearfix"></div>
                    </div>
                    <div class="panel-body container-items"><!-- widgetContainer -->
                        <?php foreach ($model->resultData as $index => $result): ?>
                            <div class="item panel panel-default"><!-- widgetBody -->
                                <div class="panel-heading">
                                    <span class="panel-title-address">Предмет ЕГЭ: <?= ($index + 1) ?></span>
                                    <button type="button" class="pull-right remove-item btn btn-danger"><i class="glyphicon glyphicon-minus"></i></button>
                                    <div class="clearfix"></div>
                                </div>
                                <div class="panel-body">
                                    <div class="col-md-6">
                                        <?= $form->field($result, "[{$index}]subject_id")->dropDownList(DictCseSubjectHelper::subjectCseUserList($isKeys)) ?>
                                    </div>
                                    <div class="col-md-6">
                                        <?= $form->field($result, "[{$index}]mark")->textInput(['maxlength' => true]) ?>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                    <?php DynamicFormWidget::end(); ?>
                </div>
            </div>
            <div class="form-group">
                <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
            </div>
            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>