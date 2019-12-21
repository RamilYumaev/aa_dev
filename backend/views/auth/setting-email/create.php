<?php
/* @var $this yii\web\View */
/* @var $model common\auth\forms\SettingEmailForm */

use yii\bootstrap\ActiveForm;

$this->title = 'Создать';
$this->params['breadcrumbs'][] = ['label' => 'Настройки  электронных почт для рассылок', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-create">
    <div class="box">
        <div class="box-body">
            <?php $form = ActiveForm::begin(); ?>
            <?= $this->render('_form', ['model'=> $model, 'form'=>$form])?>
            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>
