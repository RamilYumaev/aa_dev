<?php
/* @var $this yii\web\View */
/* @var $model olympic\forms\auth\SchooLUserCreateForm */
/* @var $dataProvider yii\data\ActiveDataProvider */

use yii\grid\GridView;
use yii\helpers\Html;
use yii\grid\SerialColumn;
use yii\grid\ActionColumn;
use common\auth\models\UserSchool;
use dictionary\helpers\DictSchoolsHelper;
use dictionary\helpers\DictClassHelper;

$this->title = 'Учебные организации';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="container">
<div class="row">
    <div class="col-md-7">
    <?= GridView::widget([
            'dataProvider' => $dataProvider,
                'columns' => [
                    ['class' => SerialColumn::class],
                    ['attribute' => 'school_id',
                        'value' => function (UserSchool $model) {
                            return DictSchoolsHelper::schoolName($model->school_id);
                        },
                    ],

                    ['attribute' => 'class_id',
                        'value' => function (UserSchool $model) {
                            return DictClassHelper::classFullName($model->class_id);
                        },
                    ],
                    'edu_year',
//                    ['class' => ActionColumn::class,
//                        'template' => '{update}',
//                    ],
                ]
            ]); ?>
    </div>
    <div class="col-md-5">
        <?= $this->render('_form', ['model' => $model]) ?>
    </div>
</div>
</div>