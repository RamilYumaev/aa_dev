<?php
/* @var $model modules\entrant\forms\LanguageForm */
/* @var $form yii\bootstrap\ActiveForm */

use yii\bootstrap\ActiveForm;
use yii\helpers\Html;
use modules\dictionary\helpers\DictForeignLanguageHelper;
?>
<div class="container">
    <div class="row">
        <div class="col-md-12 mt-30">
            <h1><?= Html::encode($this->title) ?></h1>
            <?php $form = ActiveForm::begin(['id'=> 'form-address']); ?>
            <?= $form->field($model, 'language_id')->dropDownList(DictForeignLanguageHelper::listNames(),
                ['prompt'=> 'Выберите иностранный язык']) ?>
            <div class="form-group">
                <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
            </div>
            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>