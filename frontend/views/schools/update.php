<?php
/* @var $model olympic\forms\auth\SchooLUserCreateForm */
/* @var $form yii\bootstrap\ActiveForm */

use yii\bootstrap\ActiveForm;
use yii\helpers\Html;
\frontend\assets\UpdateSchoolAsset::register($this);
$this->title = 'Учебные организации';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="container">
<?php $form = ActiveForm::begin(['id'=> 'form-school-user']); ?>

    <?= $form->field($model->schoolUser, 'check_region_and_country_school')->checkbox(); ?>

    <?= $form->field($model->schoolUser, 'country_school')->dropDownList($model->schoolUser->countryList(), ['prompt'=> 'Выберите страну']) ?>

    <?= $form->field($model->schoolUser, 'region_school')->dropDownList($model->schoolUser->regionList(), ['prompt'=> 'Выберите регион']) ?>

    <?= $form->field($model->schoolUser, 'school_id')->dropDownList([''], ['prompt'=> 'Выберите учебную организацию']) ?>

    <?= $form->field($model->schoolUser, 'check_new_school')->checkbox(); ?>

    <?= $form->field($model->schoolUser, 'check_rename_school')->checkbox(); ?>

    <?= $form->field($model->schoolUser, 'new_school')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model->schoolUser, 'class_id')->dropDownList($model->schoolUser->classFullNameList()) ?>

    <?= $form->field($model,  'country_id')->hiddenInput()->label('') ?>

    <?= $form->field($model,  'region_id')->hiddenInput()->label('') ?>

    <?= $form->field($model->schoolUser,  'school')->hiddenInput()->label('') ?>

    <?= $form->field($model->schoolUser,  'region_school_h')->hiddenInput()->label('') ?>

    <?= $form->field($model->schoolUser,  'country_school_h')->hiddenInput()->label('') ?>

    <div class="form-group">
        <?php if(!Yii::$app->user->identity->isUserOlympic()) : ?>
    <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
        <?php endif;  ?>
    </div>



<?php ActiveForm::end(); ?>

</div>