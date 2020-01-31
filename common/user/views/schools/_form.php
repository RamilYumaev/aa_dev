<?php
/* @var $model olympic\forms\auth\SchooLUserCreateForm */
/* @var $form yii\bootstrap\ActiveForm */

use yii\bootstrap\ActiveForm;
use yii\helpers\Html;
?>
<?php $form = ActiveForm::begin(['id'=> 'form-school-user']); ?>

    <?= $form->field($model->schoolUser, 'check_region_and_country_school')->checkbox(); ?>

    <?= $form->field($model->schoolUser, 'country_school')->dropDownList($model->schoolUser->countryList(), ['prompt'=> 'Выберите страну']) ?>

    <?= $form->field($model->schoolUser, 'region_school')->dropDownList($model->schoolUser->regionList(), ['prompt'=> 'Выберите регион']) ?>

    <?= $form->field($model->schoolUser, 'school_id')->widget(\kartik\select2\Select2::class, [
        'data' => '',
        'options' => ['placeholder' => 'Выберите учебную организацию'],
        'pluginOptions' => [
            'allowClear' => true
        ],
    ]); ?>

    <?= $form->field($model->schoolUser, 'check_new_school')->checkbox(); ?>

    <?= $form->field($model->schoolUser, 'check_rename_school')->checkbox(); ?>

    <?= $form->field($model->schoolUser, 'new_school')->textInput(['maxlength' => true]) ?>

    <?php if ($model->schoolUser->role == \olympic\helpers\auth\ProfileHelper::ROLE_STUDENT) : ?>
        <?= $form->field($model->schoolUser, 'class_id')->dropDownList($model->schoolUser->classFullNameList()) ?>
    <?php endif; ?>

    <div class="form-group">
        <?php if(!Yii::$app->user->identity->isUserOlympic()) : ?>
    <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
        <?php endif;  ?>
    </div>

    <?= Html::activeHiddenInput($model,  'country_id') ?>

    <?= Html::activeHiddenInput($model,  'region_id') ?>

    <?= Html::activeHiddenInput($model->schoolUser,  'school') ?>

    <?= Html::activeHiddenInput($model->schoolUser,  'region_school_h') ?>

    <?= Html::activeHiddenInput($model->schoolUser,  'country_school_h')?>

<?php ActiveForm::end(); ?>

