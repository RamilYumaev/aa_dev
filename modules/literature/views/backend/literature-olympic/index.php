<?php

use modules\entrant\helpers\SelectDataHelper;
use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $searchModel modules\literature\forms\search\LiteratureOlympciSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Участники ВОШ по литературе 2022';
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="literature-olympic-index">
    <div class="row">
        <div class="col-md-12">
            <div class="box box-success table-responsive">
                <div class="box-header">
                    <h4>Список</h4>
                    <?= Html::a("Данные в Excel",
                        Yii::$app->request->queryString ? ['export?'.Yii::$app->request->queryString]: ['literature-olympic/export'], ['class' => 'btn btn-info'])?>
                    <?= Html::a("Добавить нового участника", ['create'], ['class' => 'btn btn-success'])?>
                </div>
                <div class="box-body">
                    <?= GridView::widget([
                        'dataProvider' => $dataProvider,
                        'filterModel' => $searchModel,
                        'columns' => [
                            ['format' => "raw",
                                'value' => function($model) {
                                    return Html::a("ЛК", \Yii::$app->params['staticHostInfo'] . '/switch-user/by-user-id?id=' . $model->user_id,
                                        ['class' => 'btn btn-info', 'target' => '_blank']);
                                }],
                            ['format' => "raw",
                                'value' => function($model) {
                                    return $model->is_success ? "" : Html::a("Подтвердить", ['success', 'id'=> $model->id,], ['class' => 'btn btn-success',
                                        'data' => [
                                            'confirm' => 'Вы уверены, что хотите это сделать?',
                                            'method' => 'post',
                                        ]]);
                                }],
                            ['class' => 'yii\grid\ActionColumn', 'template' => '{view} {update}'],
                            ['class' => 'yii\grid\SerialColumn'],
                            'id',
                            'user_id',
                            'code',
                            'mark_end',
                            'code_two',
                            'mark_end_two',
                            'code_three',
                            'mark_end_three',
                            'mark_end_last',
                            ['attribute'=> 'status_last',
                                'filter' => $searchModel->getUserStatuses(),
                                'value' => 'statusUserName'],
                            ['attribute'=> 'is_success',
                                'filter' => ['Нет', 'Да'],
                                'value' => 'successName'],
                            ['format' => "raw",
                                    'value' => function($model) {
                                   return $model->photo ? Html::a("Фото", ['get-file', 'id'=> $model->id, 'name'=>'photo']) : "";
                            }],
                            ['format' => "raw",
                                'value' => function($model) {
                                    return $model->agree_file ?  Html::a("ПДН", ['get-file', 'id'=> $model->id, 'name'=>'agree_file']) : "";
                                }],
                            ['attribute'=> 'last_name',
                                'label' => "Фамилия",
                                'value' => 'user.profiles.last_name'],
                            ['attribute'=> 'first_name',
                                'label' => "Имя",
                                'value' => 'user.profiles.first_name'],
                            ['attribute'=> 'patronymic',
                                'label' => "Отчество",
                                'value' => 'user.profiles.patronymic'],
                            ['attribute'=> 'email',
                                'value' => 'user.email'],
                            ['attribute'=> 'phone',
                                'label' => "Телефон",
                                'value' => 'user.profiles.phone'],
                            ['attribute'=> 'gender',
                                'label' => "Пол",
                                'filter' => \olympic\helpers\auth\ProfileHelper::typeOfGender(),
                                'value' =>  'genderName'],
                            'birthday:date',
                            ['attribute'=> 'type',
                                'filter' => $searchModel->getDocuments(),
                                'value' => 'typeName'],
                            'series',
                            'number',
                            'date_issue',
                            'authority',
                            ['attribute'=> 'region',
                                'filter' => \dictionary\helpers\DictRegionHelper::regionList(),
                                'value' => 'regionName'],
                            'zone',
                            'city',
                            'full_name',
                            'short_name',
                            ['attribute'=> 'status_olympic',
                                'filter' => $searchModel->getOlympicStatuses(),
                                'value' => 'statusName'],
                            'mark_olympic',
                            ['attribute'=> 'grade_number',
                                'filter' => $searchModel->getGrades(),
                                'value' => 'grade_number'],
                            ['attribute'=> 'grade_letter',
                                'filter' => $searchModel->getLetters(),
                                'value' => 'gradeLetterName'],
                            ['attribute'=> 'grade_performs',
                                'filter' => $searchModel->getGrades(),
                                'value' => 'grade_performs'],
                            'fio_teacher',
                            'place_work',
                            'post',
                            ['attribute'=> 'academic_degree',
                                'filter' => $searchModel->getAcademicDegreeList(),
                                'value' => 'academicName'],
                            ['attribute'=> 'size',
                                'filter' => $searchModel->getSizes(),
                                'value' => 'size'],
                            ['attribute'=> 'is_allergy',
                                'filter' => ['Нет', 'Да'],
                                'value' => 'is_allergy:boolean'],
                            'note_allergy:ntext',
                            ['attribute'=> 'is_voz',
                                'filter' => ['Нет', 'Да'],
                                'value' => 'is_voz:boolean'],
                            ['attribute'=> 'is_need_conditions',
                                'filter' => ['Нет', 'Да'],
                                'value' => 'is_need_conditions:boolean'],
                            'note_conditions:ntext',
                            'note_special:ntext',
                            ['attribute'=> 'personal',
                                'format'=> "raw",
                                'filter'=> SelectDataHelper::dataSearchModel($searchModel,  \modules\literature\models\PersonsLiterature::find()->select(['CONCAT(fio, \' \', id)'])->indexBy('id')->column(), 'personal', 'personals'),
                                'label' => "Сопровождающие",
                                'value' =>  'personals'],
                            'date_arrival:datetime',
                            ['attribute'=> 'type_transport_arrival',
                                'filter' => $searchModel->getTransports(),
                                'value' => 'typeTransportArrivalName'],
                            'place_arrival',
                            'number_arrival',
                            'date_departure:datetime',
                            ['attribute'=> 'type_transport_departure',
                                'filter' => $searchModel->getTransports(),
                                'value' => 'typeTransportDepartureName'],
                            'place_departure',
                            'number_departure',
                        ],
                    ]); ?>
                </div>
            </div>
        </div>
    </div>
</div>
