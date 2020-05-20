<?php
/* @var $model modules\entrant\forms\AdditionalInformationForm */
/* @var $form yii\bootstrap\ActiveForm */

use dictionary\helpers\DictCompetitiveGroupHelper;
use modules\dictionary\helpers\DictDefaultHelper;
use yii\bootstrap\ActiveForm;
use yii\helpers\Html;

?>
<div class="container">
    <div class="row">
        <div class="col-md-12 mt-30">
            <h1><?= Html::encode($this->title) ?></h1>
            <?php $form = ActiveForm::begin(['id'=> 'form-additional-information']); ?>
            <?= $form->field($model, 'resource_id')->dropDownList(DictDefaultHelper::listInfo()); ?>
            <?= $form->field($model, 'voz_id')->checkbox(); ?>
            <?php if (DictCompetitiveGroupHelper::formOchExistsUser($model->user_id)): ?>
            <?= $form->field($model, 'hostel_id')->checkbox(); ?>
            <?php endif; ?>
            <div class="form-group">
                <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
            </div>
            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>