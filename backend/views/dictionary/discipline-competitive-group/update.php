<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $disciplineCompetitiveGroup dictionary\models\DisciplineCompetitiveGroup */
/* @var $model dictionary\forms\DisciplineCompetitiveGroupForm */
/* @var $form yii\widgets\ActiveForm */

$this->title = 'Обновить: ';
$this->params['breadcrumbs'][] = ['label' => 'Конкурсные группы', 'url' => ['index']];
$this->params['breadcrumbs'][] = 'Обновить';
?>
<div>
    <?php $form = ActiveForm::begin([ 'enableClientValidation' => true, 'id' => 'form-discipline-competitive-group', ]); ?>
    <div class="box box-default">
        <div class="box-body">
            <?= $form->field($model, 'discipline_id')->dropDownList($model->disciplineList(),['prompt'=> 'Выберите дисциплину']) ?>
            <?= $form->field($model, 'priority')->dropDownList($model->priorityList()) ?>
            <?= $form->field($model, 'spo_discipline_id')->dropDownList($model->disciplineSpoList(),['prompt'=> 'Выберите специальную дисциплину для СПО']) ?>
        </div>
    </div>

    <div class="form-group">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>
</div>

