<?php
/* @var $this yii\web\View */
/* @var $model modules\entrant\forms\UserDisciplineCseForm */
/* @var $nameExam */
/* @var $keyExam */
/* @var $isBelarus */
/* @var $cg DictCompetitiveGroup */
/* @var $cgs */

use dictionary\models\DictCompetitiveGroup;
use modules\entrant\models\UserDiscipline;
use yii\bootstrap\ActiveForm;
use yii\helpers\Html;
$this->title = "Вступительные испытания. Уточнение. ". $nameExam;

$this->params['breadcrumbs'][] = ['label' => 'Заполнение персональной карточки поступающего', 'url' => ['/abiturient/default/index']];
$this->params['breadcrumbs'][] = $this->title;

$data = (new UserDiscipline())->getTypeListKey('name_short');
unset($data[UserDiscipline::CT_VI], $data[UserDiscipline::CT],
    $data[UserDiscipline::CSE_VI], $data[UserDiscipline::CSE]);
$data[UserDiscipline::VI] = "Да";
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
            <?= $form->field($model, "discipline_select_id")->label(false)->hiddenInput(['value'=> $model->discipline_select_id ?: $keyExam])?>
            <?= $form->field($model, "type")->dropDownList($data)->label("Будете ли сдавать экзамен?") ?>
            <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
          <?php  ActiveForm::end(); ?>
        </div>
        <?= \modules\entrant\widgets\discipline\UserDisciplineSpoCgWidget::widget(['userId'=> $model->user_id, 'spoDiscipline' => $keyExam ]) ?>
    </div>
</div>

