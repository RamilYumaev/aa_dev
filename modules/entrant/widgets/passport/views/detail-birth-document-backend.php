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
            "header" => "Свидетельство о рождении",
            "type" => Box::TYPE_PRIMARY,
            "icon" => 'passport',
            "filled" => true,]) ?>

                <?= DetailView::widget([
                    'options' => ['class' => 'table table-bordered detail-view'],
                    'model' => $model,
                    'attributes' => [
                        ['value'=> $model->nationalityName, 'label'=> 'Страна выдачи'],
                        'typeName',
                        'series',
                        'number',
                        'date_of_issue:date',
                        'authority',
                    ]
                ]) ?>
    <?php Box::end() ?>
<?php endif; ?>
