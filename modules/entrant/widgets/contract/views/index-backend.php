<?php

use backend\widgets\adminlte\Box;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model modules\entrant\models\StatementAgreementContractCg */
?>
<?php if ($model) :
    Box::begin(
        ["header" => "Договор"  , "type" => Box::TYPE_WARNING,
            "collapsable" => true,
        ]
    );?>
    <?= DetailView::widget([
                'options' => ['class' => 'table table-bordered detail-view'],
                'model' => $model,
                'attributes' => [
                    'cg',
                    'number',
                    'fio',
                    'status_id',
                    'created_at:date',
                    'updated_at:date',
                ]
            ]) ?>
    <?php Box::end(); endif; ?>
