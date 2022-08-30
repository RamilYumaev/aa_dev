<?php
/* @var $this yii\web\View */
/* @var $model modules\entrant\forms\UserDisciplineCseForm */
/* @var $nameExam */
/* @var $isBelarus */
/* @var $anketa modules\entrant\models\Anketa */

use dictionary\models\DictDiscipline;
use modules\entrant\models\UserDiscipline;
use yii\bootstrap\ActiveForm;
use yii\helpers\Html;
$this->title = "Дисциплина по выбору. Уточнение. ". $nameExam;

$this->params['breadcrumbs'][] = ['label' => 'Заполнение персональной карточки поступающего', 'url' => ['/abiturient/default/index']];
$this->params['breadcrumbs'][] = $this->title;
$exam = $model->discipline_id ?: $keyExam;
$data = (new UserDiscipline())->getTypeListKey('name_short');
?>
<div class="container">
    <div class="row">
        <div class="mt-20">
            <div class="row min-scr">
                <div class="button-left">
                    <?= Html::a(Html::tag("span", "", ["class" => "glyphicon glyphicon-arrow-left"]),
                        "/abiturient", ["class" => "btn btn-warning btn-lg"]) ?>
                </div>
            </div>
            <h4><?= $this->title ?></h4>
            <?php $form = ActiveForm::begin(); ?>
            <?= $form->field($model, "discipline_id")->hiddenInput(['value'=> $model->discipline_id ?: $keyExam])->label(false) ?>
            <?php $field = $form->field($model, "discipline_select_id")->label(false); ?>
            <?php $dictDiscipline = DictDiscipline::findOne($model->discipline_id ?: $keyExam)?>
            <?php if($dictDiscipline && $dictDiscipline->composite_discipline) : ?>
                <?= $field->dropDownList($dictDiscipline->getComposite()
                    ->joinWith('dictDisciplineSelect')
                    ->select('name')
                    ->indexBy('discipline_select_id')
                    ->column())?>
            <?php else: ?>
                <?= $field->hiddenInput(['value'=> $model->discipline_select_id ?: $keyExam])?>
            <?php endif; ?>
            <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
          <?php  ActiveForm::end(); ?>
        </div>
    </div>
</div>