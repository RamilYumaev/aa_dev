<?php
/* @var $this yii\web\View */
/* @var $model modules\entrant\forms\UserDisciplineCseForm */
/* @var $models array */
/* @var $exams array */
/* @var $isBelarus bool */

use dictionary\models\DictDiscipline;
use modules\entrant\models\UserDiscipline;
use yii\bootstrap\ActiveForm;
use yii\helpers\Html;
$this->title = "Вступительные испытания + ЕГЭ".($isBelarus ? "+ ЦТ.":".")." Уточнение.";

$this->params['breadcrumbs'][] = ['label' => 'Заполнение персональной карточки поступающего', 'url' => ['/abiturient/default/index']];
$this->params['breadcrumbs'][] = $this->title;
$a = 0;
$keys = array_values(array_flip($exams));
$data = (new UserDiscipline())->getTypeListKey('name_short');
if (!$isBelarus) {
    unset($data[UserDiscipline::CT_VI], $data[UserDiscipline::CT]);
}
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
            <p class="label label-danger" align="justify">Если вы не знаете балл ЕГЭ/ЦТ, то введите значение 50</p>
            <?php $form = ActiveForm::begin(); ?>
            <table class="table">
                <tr>
                    <th>#</th>
                    <th>Экзамен</th>
                    <th>Дисциплина по выбору</th>
                    <th>Тип</th>
                    <th>Балл</th>
                    <th>Год сдачи</th>
                </tr>
            <?php foreach ($models as $index => $model):
                $key = $keys[$index];
                ?>
                <tr>
                    <td><?= ++$a ?></td>
                    <td><?= $exams[$model->discipline_id ?: $key]?>
                        <?= $form->field($model, "[$index]discipline_id")->hiddenInput(['value'=> $model->discipline_id ?: $key])->label(false) ?>
                    </td>
                    <td>
                        <?php $field = $form->field($model, "[$index]discipline_select_id")->label(false); ?>
                        <?php $dictDiscipline = DictDiscipline::findOne($model->discipline_id ?: $key)?>
                        <?php if($dictDiscipline && $dictDiscipline->composite_discipline) : ?>
                            <?= $field->dropDownList($dictDiscipline->getComposite()
                                ->joinWith('dictDisciplineSelect')
                                ->select('name')
                                ->indexBy('discipline_select_id')
                                ->column())?>
                        <?php else: ?>
                        <?= $exams[$model->discipline_select_id ?: $key]?>
                        <?= $field->hiddenInput(['value'=> $model->discipline_select_id ?: $key])?>
                        <?php endif; ?>
                    </td>
                    <td><?= $form->field($model, "[$index]type")->label("")->dropDownList($data) ?></td>
                    <td><?= $form->field($model, "[$index]mark")->label("") ?></td>
                    <td><?= $form->field($model, "[$index]year")->label("") ?></td>
                </tr>
            <?php endforeach; ?>
            </table>
            <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
          <?php  ActiveForm::end(); ?>
        </div>
    </div>
</div>

