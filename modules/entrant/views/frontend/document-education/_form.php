<?php

/* @var $model modules\entrant\forms\DocumentEducationForm */
/* @var $form yii\bootstrap\ActiveForm */

use yii\bootstrap\ActiveForm;
use yii\helpers\Html;
use modules\entrant\helpers\DateFormatHelper;
use modules\dictionary\helpers\DictIncomingDocumentTypeHelper;
use common\auth\helpers\UserSchoolHelper;
use kartik\date\DatePicker;
\modules\entrant\assets\education\DocumentEducationAsset::register($this);
?>
<div class="container">
    <div class="row">
        <div class="col-md-12 mt-30">

            <h1><?= Html::encode($this->title) ?></h1>
            <p class="label label-danger" align="justify">Обратите внимание, что поле серия является обязательным.
                Если в Вашем документе об образовании нет явного разделения на серию и номер документа,<br/>
                то условно можно считать, что буквы относятся к серии, цифры к номеру документа.
                Если же в Вашем документе только цифры без разделителя, <br/>то первые 4 цифры это серия, остальное - номер</p>
            <?php $form = ActiveForm::begin(['id'=> 'form-school-user']); ?>
            <?= $form->field($model, 'school_id')->dropDownList(UserSchoolHelper::userSchoolAll($model->user_id)) ?>
            <?= $form->field($model, 'type')->dropDownList(DictIncomingDocumentTypeHelper::listEducation($model->typeAnketa)) ?>
            <?= $form->field($model, 'series')->textInput(['maxlength' => true]) ?>
            <?= $form->field($model, 'number')->textInput(['maxlength' => true]) ?>
            <?= $form->field($model, 'date')->widget(DatePicker::class, DateFormatHelper::dateSettingWidget()); ?>
            <?= $form->field($model, 'fio')->checkbox() ?>
            <div id="no-fio-profile">
                <?= $form->field($model, 'surname')->textInput(['maxlength' => true]) ?>
                <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
                <?= $form->field($model, 'patronymic')->textInput(['maxlength' => true]) ?>
            </div>
            <div class="form-group">
                <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
            </div>
            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>
