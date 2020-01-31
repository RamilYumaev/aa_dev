<?php
/* @var $this yii\web\View */
/* @var $model olympic\forms\auth\SchooLUserCreateForm */
/* @var $dataProvider yii\data\ActiveDataProvider */

use yii\grid\GridView;
use yii\grid\SerialColumn;
use common\auth\models\UserSchool;
use dictionary\helpers\DictSchoolsHelper;
use dictionary\helpers\DictClassHelper;
use common\helpers\EduYearHelper;
use yii\helpers\Html;

$this->title = 'Учебные организации';
$this->params['breadcrumbs'][] = $this->title;
$isOlympicUser = Yii::$app->user->identity->isUserOlympic();
?>
<div class="container">
    <?php if ($isOlympicUser) : ?>
        <?= Yii::$app->session->setFlash('warning', 'Вы не можете добавлять/редактировать учебные организации, 
        так как записаны на одну из олимпиад ' . EduYearHelper::eduYear() . ' учебного года') ?>
    <?php else: ?>
    <p>
        <?= Html::a('Добавить', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?php endif; ?>
    <div class="row">
        <h1><?= Html::encode($this->title) ?></h1>
        <div class="col-md-12">
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
                                $model->edu_year == EduYearHelper::eduYear() ?
                                    Html::a("Удалить", $url, ['data' => ['confirm' => 'Вы действительно хотите удалить запись ?', 'method' => 'POST']]) : "";
                            },
                            'update' => function ($url, $model) use ($isOlympicUser) {
                                return !$isOlympicUser &&
                                $model->edu_year == EduYearHelper::eduYear() ?
                                    Html::a("Редактировать", $url, ['data-method' => 'post']) : "";
                            }
                        ]
                    ],
                ]
            ]); ?>
        </div>
    </div>
</div>
