<?php
/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

use yii\grid\GridView;
use yii\grid\SerialColumn;
use teacher\models\UserTeacherJob;
use dictionary\helpers\DictSchoolsHelper;
use yii\helpers\Html;

\teacher\assets\modal\ModalAsset::register($this);
$this->title = 'Данные об учебной организации';
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="row">
    <div class="col-md-12">
        <p>
            <?= Html::a('Добавить', ['create'], ['class' => 'btn btn-success']) ?>
        </p>
        <div class="box">
            <div class="box-body">
                <?= GridView::widget([
                    'dataProvider' => $dataProvider,
                    'columns' => [
                        ['class' => SerialColumn::class],
                        ['attribute' => 'school_id',
                            'value' => function (UserTeacherJob $model) {
                                return DictSchoolsHelper::schoolName($model->school_id);
                            },
                        ],
                        ['attribute' => 'school_id',
                            'label'=> "Email",
                            'value' => function (UserTeacherJob $model) {
                                return DictSchoolsHelper::schoolEmail($model->school_id);
                            },
                        ],
                        ['value' => function (UserTeacherJob $model) {
                            if ($model->isStatusDraft()) {
                            return
                                Html::a( "Добавить/изменить email",
                                ['schools-setting/add-email', 'id' => $model->school_id], ['data-pjax' => 'w0',
                                    'data-toggle' => 'modal', 'class'=>'btn btn-success', 'data-modalTitle' =>'Добавить/изменить', 'data-target' => '#modal'])
                                .
                                (!DictSchoolsHelper::schoolEmailAndStatus($model->school_id) ? "" : Html::a( "Подтвердить",
                                    ['schools-setting/send', 'id' => $model->id], ['data-pjax' => 'w0',
                                        'data-method' => 'post', 'class'=>'btn btn-info', 'data-confirm' =>'Вы уверены, что хотите отправить письмо с подтверждением?']));
                        } else {
                                return \teacher\helpers\UserTeacherJobHelper::statusName($model->status);
                            }},
                            'format'=> 'raw'
                        ],
                        ['class' => \yii\grid\ActionColumn::class,
                            'template' => '{update} {delete}',
                        ],
                    ]
                ]); ?>
            </div>
        </div>
    </div>
</div>


