<?php

use backend\widgets\adminlte\Box;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model modules\entrant\models\PassportData */
/* @var $isUserSchool bool */
?>
<?php if ($model) : ?>
    <?php Box::begin(
        [
            "header" => "Документ, удостоверяющий личность",
            "type" => Box::TYPE_PRIMARY,
            "icon" => 'passport',
            "filled" => true,]) ?>

                <?= DetailView::widget([
                    'options' => ['class' => 'table table-bordered detail-view'],
                    'model' => $model,
                    'attributes' => [
                        'nationalityName',
                        'typeName',
                        'series',
                        'number',
                        'date_of_birth:date',
                        'place_of_birth',
                        'date_of_issue:date',
                        'authority',
                        'division_code',
                    ]
                ]) ?>
    <?php Box::end() ?>
<?php endif; ?>
