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
<div class="container mt-50">
    <?php if ($isOlympicUser) : ?>
        <?= Yii::$app->session->setFlash('warning', 'Вы не можете добавлять/редактировать учебные организации, 
        так как записаны на одну из олимпиад ' . EduYearHelper::eduYear() . ' учебного года') ?>
    <?php endif; ?>
    <?= Yii::$app->user->identity->anketa() ? Html::a('Персональная карточка поступающего', ['/abiturient/default/index'], ['class'=> 'btn btn-warning']) : ''?>
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
                        'format'=>'raw',
                        'value' => function (UserSchool $model)
                        use ($isOlympicUser) {
                            return DictClassHelper::getList()[$model->class_id]. "".
                                (!$isOlympicUser &&
                            $model->edu_year == EduYearHelper::eduYear() ? Html::a('Изменить',
                                    ['change-class', 'id' => $model->id], ['data-pjax' => 'w78'.$model->id, 'data-toggle' => 'modal',
                                        'data-target' => '#modal', 'class'=>'btn btn-warning btn-xs pull-right', 'data-modalTitle' => "Изменить"]):'');
                        },
                    ],
                    'edu_year',
                    ['class' => \yii\grid\ActionColumn::class,
                        'template' => '{delete}',
                        'buttons' => [
                            'delete' => function ($url, $model) use ($isOlympicUser) {
                                return !$isOlympicUser &&
                                $model->edu_year == EduYearHelper::eduYear() ?
                                    Html::a("Удалить", $url, ['data' => ['confirm' => 'Вы действительно хотите удалить запись ?', 'method' => 'POST']]) : "";
                            },
                        ]
                    ],
                ]
            ]); ?>
        </div>
    </div>
</div>
