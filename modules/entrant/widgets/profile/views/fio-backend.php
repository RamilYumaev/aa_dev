<?php

use backend\widgets\adminlte\Box;
use modules\entrant\helpers\BlockRedGreenHelper;
use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $fio modules\entrant\models\FIOLatin */

?>
<?php if ($fio) : ?>
    <?php Box::begin(
        [
            "header" => "ФИО на латинском",
            "type" => Box::TYPE_INFO,
            "collapsable" => true,
            "filled" => true,]) ?>

        <table class="table">
            <tbody><tr>
                <th style="width:50%"><?= $fio->getAttributeLabel('surname') ?></th>
                <td><?= $fio['surname'] ?></td>
            </tr>
            <tr>
                <th><?= $fio->getAttributeLabel('name') ?></th>
                <td><?= $fio['name']?></td>
            </tr>
            <?php if($fio['patronymic']): ?>
                <tr>
                    <th><?= $fio->getAttributeLabel('patronymic') ?></th>
                    <td><span class="badge bg-blue"><?= $fio['patronymic'] ?></span></td>
                </tr>
            <?php endif; ?>
            </tbody>
        </table>

    <?php Box::end() ?>
<?php endif; ?>