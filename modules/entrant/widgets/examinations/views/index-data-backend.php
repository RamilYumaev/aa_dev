<?php
/* @var $this yii\web\View */
/* @var $exams array */

/* @var $model modules\entrant\models\CseViSelect */

use backend\widgets\adminlte\Box;use modules\dictionary\helpers\DictCseSubjectHelper;
use modules\entrant\helpers\BlockRedGreenHelper;
use yii\helpers\Html;
use modules\entrant\helpers\CseViSelectHelper;

?>
<?php Box::begin(
        [
            "header" => "Вступительные испытания (ВИ) /EГЭ",
            "type" => Box::TYPE_SUCCESS,
            "icon" => 'passport',
            "filled" => true,]) ?>
            <table class="table">
                <tr>
                    <th>#</th>
                    <th>Список дисциплин</th>
                    <th>Вступительное испытание (ВИ) /EГЭ</th>
                    <th>Год сдачи ЕГЭ</th>
                    <th>Балл ЕГЭ</th>
                    <th></th
                </tr>
                <?php $a = 1;
                foreach ($exams as $i => $item):
                    $data = $model ? (CseViSelectHelper::inKeyVi($i, $model->dataVi()) ?? CseViSelectHelper::inKeyCse($i, $model->dataCse())) : null;
                    if($model && $i == DictCseSubjectHelper::LANGUAGE) {
                        if(CseViSelectHelper::inKeyVi(DictCseSubjectHelper::LANGUAGE, $model->dataVi())) {
                            $discipline = DictCseSubjectHelper::listLanguage()[$model->dataVi()[$i]];
                        } elseif(CseViSelectHelper::inKeyCse(DictCseSubjectHelper::LANGUAGE, $model->dataCse())) {
                            $discipline = DictCseSubjectHelper::listLanguage()[(CseViSelectHelper::inKeyCse($i, $model->dataCse(), 1))];
                        } else {
                            $discipline = $item;
                        }
                    }else {
                        $discipline = $item;
                    }
                    ?>
                    <tr class="<?= $data ? 'success' : 'danger' ?>">
                        <td><?= $a++; ?></td>
                        <td><?= $discipline ?></td>
                        <td><?= $data ?? "Нет данных" ?></td>
                        <td><?= $model ? (CseViSelectHelper::inKeyCse($i, $model->dataCse(), 0)) : "" ?></td>
                        <td><?= $model ? (CseViSelectHelper::inKeyCse($i, $model->dataCse(), 2)) : "" ?></td>
                    </tr>
                <?php endforeach;  ?>
            </table>
<?php Box::end()?>
