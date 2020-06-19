<?php
/* @var $model modules\entrant\forms\AdditionalInformationForm */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $anketaMoscow bool */
/* @var $addressMoscow \modules\entrant\models\Address */

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
            <?php if (DictCompetitiveGroupHelper::eduSpoExistsUser($model->user_id)): ?>
                <?= $form->field($model, 'mark_spo')->textInput(); ?>
            <?php endif; ?>
            <?= $form->field($model, 'chernobyl_status_id')->checkbox(); ?>
            <?= $form->field($model, 'mpgu_training_status_id')->checkbox(); ?>
            <?= $form->field($model, 'voz_id')->checkbox(); ?>
            <?php if ($anketaMoscow && DictCompetitiveGroupHelper::formOchExistsUser($model->user_id)): ?>
            <?php if (is_null($addressMoscow) || ($addressMoscow && !$addressMoscow->isMoscow())): ?>
                <?= $form->field($model, 'hostel_id')->checkbox(); ?>
            <?php endif; ?>
            <?php endif; ?>
            <div class="form-group">
                <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
            </div>
            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>