<?php
use modules\dictionary\helpers\DictDefaultHelper;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model yii\db\BaseActiveRecord */

?>
<div class="row">
    <div class="col-md-12">
        <h4>Преимущественное право</h4>
        <?= Html::a("Добавить/Редактировать", ["preemptive-right/index"], ["class" => "btn btn-success"]) ?>
        <?php if($model):?>
        <table class="table table-bordered">
            <tr>
                <th>Приоритет</th>
                <th>Категории, имеющие ПП</th>
            </tr>
            <?php foreach ($model as $item) : ?>
                <tr>
                    <td><?= $item->type_id ?></td>
                    <td><?= DictDefaultHelper::preemptiveRightName($item->type_id) ?></td>
                </tr>
            <?php  endforeach; ?>
        </table>
        <?php endif; ?>
    </div>
</div>