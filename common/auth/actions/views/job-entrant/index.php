<?php

/* @var $this yii\web\View */

/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \modules\dictionary\forms\JobEntrantAndProfileForm */
/* @var $jobEntrant \modules\dictionary\models\JobEntrant */

use dmstr\widgets\Alert;
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\helpers\Url;

\common\auth\actions\assets\LoginAsset::register($this);
\common\auth\actions\assets\EntrantAsset::register($this);
$this->title = "Приемная комиссия МПГУ";
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="login-box">
    <div class="login-box-body">
        <?= Alert::widget() ?>
        <?= Html::a('на главную', '/', ['class' => 'btn-lg']) ?>
            <?= Html::beginForm(['/account/logout'], 'post', ['id' => 'logout'])
            . Html::submitButton(
                'Выйти',
                ['class' => 'btn btn-danger pull-right']
            )
            . Html::endForm(); ?>
        <div class="login-logo">
            <h3><?= $this->title ?></h3>
            <h5>Данные сотрудника</h5>
        </div><!-- /.login-logo -->
        <?php $form = ActiveForm::begin(['id' => 'form-signup']); ?>
        <div class="form-group has-feedback">

            <?= $form->field($model->profile, 'last_name')->textInput(['maxlength' => true]) ?>
            <?= $form->field($model->profile, 'first_name')->textInput(['maxlength' => true]) ?>
            <?= $form->field($model->profile, 'patronymic')->textInput(['maxlength' => true]) ?>
            <?= $form->field($model->profile, 'gender')->dropDownList(\olympic\helpers\auth\ProfileHelper::typeOfGender()) ?>
            <?= $form->field($model->profile, 'phone')->widget(\borales\extensions\phoneInput\PhoneInput::class, [
                'jsOptions' => ['preferredCountries' => ['ru'], 'separateDialCode'=>true]
            ]) ?>
            <?= $form->field($model->jobEntrant, 'category_id')->dropDownList(\modules\dictionary\helpers\JobEntrantHelper::listCategories()) ?>
            <?= $form->field($model->jobEntrant, 'post')->dropDownList(\modules\dictionary\helpers\JobEntrantHelper::postList()) ?>
            <?= $form->field($model->jobEntrant, 'faculty_id')->dropDownList(\dictionary\helpers\DictFacultyHelper::facultyIncomingList()) ?>
            <?= $form->field($model->jobEntrant, 'examiner_id')->dropDownList(\modules\dictionary\helpers\DisciplineExaminerHelper::listExaminer()) ?>
        </div>
        <div class="row">
            <div class="col-md-6 col-md-offset-3">
                <?= Html::submitButton('Сохранить', ['class' => 'btn btn-primary btn-lg btn-block', 'name' => 'login-button']) ?></div>
                <?= $form->field($model, 'id_key')->hiddenInput()->label(false) ?>
        </div>
        <?php ActiveForm::end() ?>
    </div>

