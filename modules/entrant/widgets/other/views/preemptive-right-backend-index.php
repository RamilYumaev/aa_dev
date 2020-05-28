<?php

use backend\widgets\adminlte\Box;
use modules\dictionary\helpers\DictDefaultHelper;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model yii\db\BaseActiveRecord */

?>
<?php Box::begin(
    ["header" => "Преимущественное право", "type" => Box::TYPE_PRIMARY,
        "collapsable" => true,
    ]
)
?>
            <?php if ($model): ?>
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
                    <?php endforeach; ?>
                </table>
            <?php endif; Box::end(); ?>
