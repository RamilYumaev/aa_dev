<?php
/* @var $this yii\web\View */

use modules\dictionary\helpers\DictDefaultHelper;
use yii\bootstrap\ActiveForm;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use yii\helpers\Html;
/* @var $this yii\web\View */
/* @var $searchModel modules\entrant\searches\ProfilesStatementSearch/
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Получить токен';
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="box">
    <div class="box-header">
    </div>
    <div class="box-body">
        <?php $form = ActiveForm::begin(['id' => 'token', 'options' => []]); ?>
        <?= Html::label("Логин", ['class'=>'form-control'])?>
        <?= Html::textInput("username", '',['class'=>'form-control'])?>
        <?= Html::label("Пароль", ['class'=>'form-control'])?>
        <?= Html::passwordInput("password", '', ['class'=>'form-control'])?>
    </div>
    <div class="box-footer">
        <?= Html::submitButton("Сохранить ответ", ['class' => 'btn btn-success']) ?>
    </div>
    <?php ActiveForm::end(); ?>
</div>
