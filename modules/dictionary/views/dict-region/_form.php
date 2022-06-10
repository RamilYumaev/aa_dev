<?php
/* @var $model modules\dictionary\forms\DictCategoryForm */
/* @var $form yii\bootstrap\ActiveForm */

use yii\bootstrap\ActiveForm;
use yii\helpers\Html;
?>

<div class="box">
    <div class="box-body">
        <h1><?= Html::encode($this->title) ?></h1>
        <?php $form = ActiveForm::begin(['id'=> 'form-region']); ?>
        <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
        <?= $form->field($model, 'ss_id')->widget(\kartik\select2\Select2::class,
             [
                'data' => $model->getListSS(),
                'options' => ['placeholder' => 'Выберите ...'],
                'pluginOptions' => [
                    'allowClear' => true,
                ]]
        ) ?>
        <div class="form-group">
            <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
        </div>
        <?php ActiveForm::end(); ?>
    </div>
</div>
