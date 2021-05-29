<?php
/* @var $model \modules\entrant\forms\TestingEntrantDictForm */
/* @var $form yii\bootstrap\ActiveForm */

use yii\bootstrap\ActiveForm;
use yii\helpers\Html;
use mihaildev\ckeditor\CKEditor;
use mihaildev\elfinder\ElFinder;
?>
<?php $form = ActiveForm::begin(['id'=> 'form-message']); ?>
        <?= $form->field($model, 'message')->widget(CKEditor::class, [
            'editorOptions' => ElFinder::ckeditorOptions('elfinder', ['filter' => 'flash']),
        ]); ?>
    <div class="form-group">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
    </div>
<?php ActiveForm::end(); ?>