<?php
/* @var $this yii\web\View */
/* @var $exams array */
/* @var $model modules\entrant\models\CseViSelect*/

use yii\helpers\Html;
use modules\entrant\helpers\CseViSelectHelper;
?>
<div>
    <h4>Вступительные испытания (ВИ) /EГЭ</h4>
    <?= Html::a('Уточнить', ['cse-subject-result/cse-vi'], ['class' => 'btn btn-success mb-10']) ?>
    <table class="table">
        <tr><th>#</th><th>Список дисциплин</th><th>Вступительное испытание (ВИ) /EГЭ</th><th>Год сдачи ЕГЭ</th> <th>Балл ЕГЭ</th><th></th</tr>
        <?php $a=1; foreach($exams as $i => $item):
        $data = $model ? (CseViSelectHelper::inKeyVi($i, $model->dataVi()) ??  CseViSelectHelper::inKeyCse($i, $model->dataCse())) : null;
            ?>
            <tr class="<?= $data ? 'success':'danger'?>">
                <td><?= $a++; ?></td>
                <td><?= $item; ?></td>
                <td><?= $data ?? "Нет данных" ?></td>
                <td><?= $model ? (CseViSelectHelper::inKeyCse($i, $model->dataCse(),0)) : "" ?></td>
                <td><?= $model ? (CseViSelectHelper::inKeyCse($i, $model->dataCse(),2)) : "" ?></td>
            </tr>
        <?php endforeach; ?>
    </table>
</div>
