<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $models testing\forms\AddFinalMarkTableForm*/
/* @var $form yii\widgets\ActiveForm */
?>
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