<?php

/* @var $phone \olympic\models\auth\Profiles */
/* @var $model frontend\search\Profile*/
/* @var $user common\auth\models\User*/
/* @var $listProfiles */

use yii\widgets\ActiveForm;
use yii\helpers\Html;

$this->title = "Переключение на другого пользователя";
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="container mt-50">
    <h1><?= $this->title ?></h1>
    <div class="row">
        <div class="col-md-12">
            <?php $form = ActiveForm::begin(['id' => 'form-switch-user', 'action' => ['index'], 'method' => 'get']); ?>
            <?= $form->field($model, 'phone')->textInput() ?>
            <?= $form->field($model, 'email')->textInput() ?>
            <?= $form->field($model, 'last_name')->textInput() ?>
            <?= $form->field($model, 'first_name')->textInput() ?>
            <?= $form->field($model, 'patronymic')->textInput() ?>
            <?= Html::submitButton("Найти", ['class' => 'btn btn-success']) ?>
            <?php ActiveForm::end() ?>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <?= $this->render('user', ['model'=> $model, 'user'=> $user]) ?>
        </div>
        <div class="col-md-6">
            <?= $this->render('phone', ['model'=> $model, 'phone' =>$phone]) ?>
        </div>
    </div>
    <?php if(!$phone && !$user && ($model->last_name && $model->first_name)) :?>
    <div class="row">
        <div class="col-md-12">
            <?= $this->render('list_profiles', ['model'=> $model, 'listProfiles'=> $listProfiles]) ?>
        </div>
    </div>
    <?php endif;?>
</div>

