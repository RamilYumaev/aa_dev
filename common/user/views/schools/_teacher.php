<?php
/* @var $this yii\web\View */
/* @var $model olympic\forms\auth\SchooLUserCreateForm */

use yii\bootstrap\ActiveForm;
use yii\helpers\Html;
?>
<div class="row">
    <div class="col-md-12">
        <div class="box">
            <div class="box-body">
                <?php $form = ActiveForm::begin(['id'=> 'form-school-user']); ?>
                <?= $this->render('_form', ['model' => $model, 'form' => $form]) ?>
                <div class="form-group">
                    <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
                </div>
                <?php ActiveForm::end(); ?>
            </div>
        </div>
    </div>
</div>
