<?php

/* @var $this yii\web\View */
/* @var $model \olympic\forms\auth\UserEditForm */


use common\auth\helpers\UserHelper;
use kartik\select2\Select2;
use yii\bootstrap\ActiveForm;
use yii\helpers\Html;

$this->title = 'Обновить пользователя: ' . $user->id;
$this->params['breadcrumbs'][] = ['label' => 'Пользователи', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $user->id, 'url' => ['view', 'id' => $user->id]];
$this->params['breadcrumbs'][] = 'Обновление';
?>
<div class="user-update">
    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'username')->textInput(['maxLength' => true]) ?>
    <?= $form->field($model, 'email')->textInput(['maxLength' => true]) ?>
    <?= $form->field($model, 'status')->dropDownList(UserHelper::statusList()) ?>
    <?= $form->field($model, 'role')->widget(Select2::class, [
            'data' => $model->rolesList(),
        'options' => ['placeholder' => 'Выберите классы и курсы', 'multiple' => true],
        'pluginOptions' => [
            'allowClear' => true,
        ],
    ]) ?>

    <div class="form-group">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
