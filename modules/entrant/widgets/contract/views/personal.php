<?php

use backend\widgets\adminlte\Box;
use modules\entrant\widgets\file\FileListWidget;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model modules\entrant\models\PersonalEntity */
?>
<?php if ($model) :
    Box::begin(
        ["header" => "Данные о законном представителе - Заказчике платных образовательных услуг"  , "type" => Box::TYPE_DANGER,
            "collapsable" => true,
        ]
    );?>
    <?= DetailView::widget([
                'options' => ['class' => 'table table-bordered detail-view'],
                'model' => $model,
                'attributes' => [
                    'surname',
                    'name',
                    'patronymic',
                    'series',
                    'number',
                    'division_code',
                    'date_of_issue',
                    'authority',
                    'phone',
                    'postcode',
                    'region',
                    'district',
                    'city',
                    'village',
                    'street',
                    'house',
                    'housing',
                    'building',
                    'flat',
                    'email',
                ]
            ]) ?>

    <?= FileListWidget::widget([ 'view' => 'list-backend', 'record_id' => $model->id, 'model' => $model::className(), 'userId' => $model->user_id]) ?>

    <?php Box::end(); endif; ?>
