<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $model \olympic\forms\SpecialTypeOlimpicCreateForm */
/* @var $form yii\widgets\ActiveForm */
?>
<div>
    <?php $form = ActiveForm::begin(['id' => 'form-olympic-spec-type']); ?>
    <div class="box box-default">
        <div class="box-body">
            <?= $form->field($model, 'special_type_id')->dropDownList($model->specialTypeOlimpicList()) ?>
        </div>
    </div>

    <div class="form-group">
        <?= Html::a('Сохранить',$form->action,['class'=>'btn btn-primary','data-method'=>'POST']); ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
