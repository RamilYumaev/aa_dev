<?php

use backend\widgets\adminlte\Box;
use modules\entrant\widgets\file\FileListWidget;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model modules\entrant\models\LegalEntity */
?>
<?php if ($model) :
    Box::begin(
        ["header" => "Данные о Юридическом лице - Заказчике платных образовательных услуг"  , "type" => Box::TYPE_WARNING,
            "collapsable" => true,
        ]
    );?>
    <?= DetailView::widget([
                'options' => ['class' => 'table table-bordered detail-view'],
                'model' => $model,
                'attributes' => [
                    'bank',
                    'bik',
                    'p_c',
                    'k_c',
                    'ogrn',
                    'inn',
                    'name',
                    'address_postcode',
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
                    'patronymic',
                    'surname',
                    'first_name',
                    'phone',
                    'requisites',
                    'fio',
                    'footing',
                    'position'
                ]
            ]) ?>
    <?= FileListWidget::widget([ 'view' => 'list-backend', 'record_id' => $model->id, 'model' => $model::className(), 'userId' => $model->user_id]) ?>
    <?php Box::end(); endif; ?>
