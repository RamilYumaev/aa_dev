<?php
/* @var $model \modules\transfer\search\PersonsSearch */
use yii\bootstrap\ActiveForm;
use yii\helpers\Html; ?>

<?php $form = ActiveForm::begin(['action' => ['step5'], 'method' => 'get']); ?>
<?= $form->field($model, 'phone')->textInput()->label('Телефон') ?>
<?= $form->field($model, 'email')->textInput() ?>
    <div class="form-group">
        <?= Html::submitButton('Найти', ['class' => 'btn btn-success']) ?>
    </div>
<?php ActiveForm::end(); ?>