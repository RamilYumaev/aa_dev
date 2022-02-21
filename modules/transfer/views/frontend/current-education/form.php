<?php
/* @var  $this \yii\web\View  */
/* @var $model modules\transfer\models\CurrentEducation
/* @var $form yii\bootstrap\ActiveForm */
use common\auth\helpers\UserSchoolHelper;
use yii\bootstrap\ActiveForm;
use yii\helpers\Html;
$this->title = "Действующее образование. Заполнение формы";
?>
<div class="container">
    <div class="row">
        <div class="col-md-12 mt-30">
            <h1><?= Html::encode($this->title) ?></h1>
            <p><?= Html::a('Ваши учебные организации',
                    ['/schools', 'redirect' => 'transfer-registration'], ['class' => 'btn btn-warning']) ?></p>
            <?php $form = ActiveForm::begin(['id'=> 'form-school-user']); ?>
            <?= $form->field($model, 'school_id')->dropDownList(UserSchoolHelper::userSchoolAll($model->user_id)) ?>
            <?= $form->field($model, 'school_name')->textInput(['maxlength' => true]) ?>
            <?= $form->field($model, 'speciality')->textInput(['maxlength' => true]) ?>
            <?= $form->field($model, 'specialization')->textInput(['maxlength' => true]) ?>
            <?= $form->field($model, 'edu_count')->dropDownList($model->listEdu()) ?>
            <?= $form->field($model, 'course')->dropDownList(\dictionary\helpers\DictClassHelper::getList()) ?>
            <?= $form->field($model, 'form')->dropDownList(\dictionary\helpers\DictCompetitiveGroupHelper::getEduForms()) ?>
            <?= $form->field($model, 'finance')->dropDownList(\dictionary\helpers\DictCompetitiveGroupHelper::listFinances())?>
            <div class="form-group">
                <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
            </div>
            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>