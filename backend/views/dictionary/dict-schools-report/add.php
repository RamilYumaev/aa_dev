<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use dictionary\helpers\CategoryDocHelper;

/* @var $this yii\web\View */
/* @var $school dictionary\models\DictSchoolsReport */

$this->title = $school->name;
$this->params['breadcrumbs'][] = ['label' => 'Учебные организации. Для отчетов', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
    <div class="school-view">
        <div class="box">
            <div class="box-body">
                <?= DetailView::widget([
                    'model' => $school,
                    'attributes' => [
                        'id',
                        'name',
                        'email:email',
                        ['attribute' => 'country_id',
                            'value' => \dictionary\helpers\DictCountryHelper::countryName($school->country_id),
                        ],
                        ['attribute' => 'region_id',
                            'value' =>  \dictionary\helpers\DictRegionHelper::regionName($school->region_id),
                        ],
                        'status'
                    ],
                ]) ?>
            </div>
        </div>
    </div>
<?= \backend\widgets\dictionary\DictSchoolsWidget::widget(['model' =>$school, 'isAdd' => false]) ?>