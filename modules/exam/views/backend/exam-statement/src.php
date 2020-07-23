<?php
/* @var $model modules\exam\forms\ExamSrcBBBForm */
/* @var $form yii\bootstrap\ActiveForm */

use yii\bootstrap\ActiveForm;
use yii\helpers\Html;
?>
<?php $form = ActiveForm::begin(['id'=> 'form-src']); ?>
    <?= $form->field($model, 'src_bbb')->textInput(); ?>
    <div class="form-group">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
    </div>
<?php ActiveForm::end(); ?>