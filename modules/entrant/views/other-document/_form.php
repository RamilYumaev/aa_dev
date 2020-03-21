<?php
/* @var $model modules\entrant\forms\OtherDocumentForm */
/* @var $form yii\bootstrap\ActiveForm */

use modules\dictionary\helpers\DictIncomingDocumentTypeHelper;
use yii\bootstrap\ActiveForm;
use yii\helpers\Html;
?>
<div class="container">
    <div class="row">
        <div class="col-md-12 mt-30">
            <h1><?= Html::encode($this->title) ?></h1>
            <?php $form = ActiveForm::begin(['id'=> 'form-address']); ?>
            <?= $form->field($model, 'type')->dropDownList(DictIncomingDocumentTypeHelper::listType([
                DictIncomingDocumentTypeHelper::TYPE_EDUCATION_PHOTO,
                DictIncomingDocumentTypeHelper::TYPE_EDUCATION_VUZ
            ])) ?>
            <?= $form->field($model, 'note')->textInput(['maxlength' => true]) ?>
            <div class="form-group">
                <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
            </div>
            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>