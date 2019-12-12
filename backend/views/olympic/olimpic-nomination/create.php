<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $model \olympic\forms\OlimpicNominationCreateForm */
/* @var $form yii\widgets\ActiveForm */
?>
<div>
    <?php $form = ActiveForm::begin(['id' => 'form-olympic-nomination', 'enableAjaxValidation' => true]); ?>
    <div class="box box-default">
        <div class="box-body">
            <?= $form->field($model, 'name')->textInput() ?>
        </div>
    </div>

    <div class="form-group">
        <?= Html::a('Сохранить',$form->action,['class'=>'btn btn-primary','data-method'=>'POST']); ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
