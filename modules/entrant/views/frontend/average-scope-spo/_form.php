<?php
/* @var $model modules\entrant\forms\AverageScopeSpoForm */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $anketaMoscow bool */

use yii\bootstrap\ActiveForm;
use yii\helpers\Html;

?>
<div class="container">
    <div class="row">
        <div class="col-md-12 mt-30">
            <h1><?= Html::encode($this->title) ?></h1>
            <?php $form = ActiveForm::begin(['id'=> 'form-average-scope-spo']); ?>
            <?= $form->field($model, 'number_of_fives')->textInput(['maxlength' => true]) ?>
            <?= $form->field($model, 'number_of_fours')->textInput(['maxlength' => true]) ?>
            <?= $form->field($model, 'number_of_threes')->textInput(['maxlength' => true]) ?>
            <div class="form-group">
                <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
            </div>
            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>