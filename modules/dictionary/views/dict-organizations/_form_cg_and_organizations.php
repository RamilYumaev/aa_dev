<?php
/* @var $model modules\dictionary\forms\DictOrganizationsAndCgForm*/
/* @var $form yii\bootstrap\ActiveForm */
/* @var $this yii\web\View */

use kartik\select2\Select2;
use yii\bootstrap\ActiveForm;
use yii\helpers\Html;
use modules\dictionary\helpers\DictOrganizationsHelper;
?>
<div class="box">
    <div class="box-body">
        <?php $form = ActiveForm::begin(['id'=> 'form-dict-organization-cg']); ?>
        <?= $form->field($model, 'competitiveGroupsList')->widget(Select2::class, [
            'options' => ['placeholder' => 'Выберите конкурсные группы', 'multiple' => true],
            'pluginOptions' => ['allowClear' => true],
            'data' => DictOrganizationsHelper::organizationList()
        ]) ?>
        <?= $this->render('_form_cg',['model'=>$model, 'form'=> $form]) ?>
        <div class="form-group">
            <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
        </div>
        <?php ActiveForm::end(); ?>
    </div>
</div>
