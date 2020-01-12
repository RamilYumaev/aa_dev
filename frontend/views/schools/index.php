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
$isOlympicUser = Yii::$app->user->identity->isUserOlympic();
?>
<div class="container">
    <?php if ($isOlympicUser) : ?>
        <?= Yii::$app->session->setFlash('warning', 'Вы не можете добавлять/редактировать учебные организации, 
        так как записаны на одну из олимпиад ' . \common\helpers\EduYearHelper::eduYear() . ' учебного года') ?>
    <?php endif; ?>
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
                    ['class' => \yii\grid\ActionColumn::class,
                        'template' => '{update} {delete}',
                        'buttons' => [
                            'delete' => function ($url, $model) use ($isOlympicUser) {
                                return !$isOlympicUser &&
                                $model->edu_year == \common\helpers\EduYearHelper::eduYear() ?
                                    \yii\helpers\Html::a("Удалить", $url, ['data' => ['confirm' => 'Вы действительно хотите удалить запись ?', 'method' => 'POST']]) : "";
                            },
                            'update' => function ($url, $model) use ($isOlympicUser) {
                                return !$isOlympicUser &&
                                $model->edu_year == \common\helpers\EduYearHelper::eduYear() ?
                                    \yii\helpers\Html::a("Редактировать", $url, ['data-method' => 'post']) : "";
                            }
                        ]
                    ],
                ]
            ]); ?>
        </div>

        <div class="col-md-5">
            <?= $this->render('_form', ['model' => $model]) ?>
        </div>
    </div>
</div>