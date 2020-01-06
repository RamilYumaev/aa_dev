<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $models testing\forms\AddFinalMarkTableForm*/
/* @var $form yii\widgets\ActiveForm */
$olympicAndYearName =  \olympic\helpers\OlympicListHelper::olympicAndYearName($olympic->id);
$this->title = $olympicAndYearName . '. Баллы участникам';
$this->params['breadcrumbs'][] = ['label' => 'Олимпиады/конкурсы', 'url' => ['olympic/olympic/index']];
$this->params['breadcrumbs'][] = ['label' => \olympic\helpers\OlympicHelper::olympicName($olympic->olimpic_id),
    'url' => ['olympic/olympic/view', 'id'=> $olympic->olimpic_id]];
$this->params['breadcrumbs'][] = ['label' => $olympicAndYearName,
    'url' => ['olympic/olimpic-list/view', 'id'=> $olympic->id]];
$this->params['breadcrumbs'][] = ['label' => "Ведомость очного тура",
    'url' => ['olympic/personal-presence-attempt/index', 'olympic_id'=> $olympic->id]];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="box">
<?php $form = ActiveForm::begin(['id' => 'add-final-mark']); ?>
    <div class="box-body">
        <table class="table">
            <tr><th>#</th><th>ФИО</th><th>Балл</th></tr>
            <?php $a=1; foreach($models->arrayMark as $i=>$item): ?>
                <tr>
                    <td><?= $a++; ?></td>
                    <td><?= \olympic\helpers\auth\ProfileHelper::profileFullName($item->attempt->user_id) ?></td>
                    <td><?= $form->field($item,"[$i]mark")->label(false)?></td>
                </tr>
            <?php endforeach; ?>
        </table>
    </div>
    <div class="box-footer">
<?= Html::submitButton('Сохранить',['class'=>'btn btn-primary']) ?>
<?php ActiveForm::end(); ?>
    </div>