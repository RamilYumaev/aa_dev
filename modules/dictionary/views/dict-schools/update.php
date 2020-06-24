<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $school dictionary\models\DictSchools */
/* @var $model dictionary\forms\DictSchoolsEditForm */
/* @var $form yii\widgets\ActiveForm */

$this->title = 'Обновить: ' . $school->name;
$this->params['breadcrumbs'][] = ['label' => 'Учебные организации', 'url' => ['index']];
$this->params['breadcrumbs'][] = 'Обновить';
?>
<div>
    <?php $form = ActiveForm::begin(['id' => 'form-school']); ?>
    <div class="box box-default">
        <div class="box-body">
            <?= $form->field($model, 'name')->textInput() ?>

            <?= $form->field($model, 'country_id')->dropDownList($model->countryList(), ["prompt" => "Выберите страну"]) ?>

            <?= $form->field($model, 'region_id')->dropDownList($model->regionList(), ["prompt" => "Выберите регион"]) ?>
        </div>
    </div>

    <div class="form-group">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
