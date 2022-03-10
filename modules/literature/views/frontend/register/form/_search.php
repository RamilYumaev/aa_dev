<?php
/* @var $model modules\literature\models\PersonsLiterature */
use yii\bootstrap\ActiveForm;
use yii\helpers\Html; ?>

<?php $form = ActiveForm::begin(['action' => ['step5'], 'method' => 'get']); ?>
<?= $form->field($model, 'phone')->widget(\borales\extensions\phoneInput\PhoneInput::class, [
    'jsOptions' => [
        'preferredCountries' => ['ru'],
        'separateDialCode'=>true
    ]
])->label('Телефон') ?>
<?= $form->field($model, 'email')->textInput() ?>
    <div class="form-group">
        <?= Html::submitButton('Найти', ['class' => 'btn btn-success']) ?>
    </div>
<?php ActiveForm::end(); ?>