<?php

/**
 * @var $olimpiad olympic\models\OlimpicList
 * @var $numTour int
 */
use olympic\helpers\OlympicHelper;
use olympic\helpers\PersonalPresenceAttemptHelper;
use olympic\helpers\auth\ProfileHelper;
use yii\grid\GridView;
use dictionary\helpers\DictSchoolsHelper;
use common\auth\helpers\UserSchoolHelper;

$this->title = $numTour == OlympicHelper::ZAOCH_FINISH ?
    'Результаты отборочного (заочного) тура олимпиады.' :
    ($olimpiad->isStatusAppeal() || $olimpiad->isStatusPreliminaryFinish() ?
        'Предварительные результаты олимпиады':'Результаты олимпиады');
if ($olimpiad->olympicSpecialityOlimpicList) {
   $columns = [['label' => 'ФИО участника',
        'format' => 'raw',
        'value' => function ($model)use($olimpiad) {
            return PersonalPresenceAttemptHelper::userOfPlacesForCert($model->user_id,
                $model->reward_status, $olimpiad);
        }],
                [
                    'label' => 'Название образовательной организации',
                    'format' => 'raw',
                    'value' => function ($model) use ($olimpiad) {
                        $school = UserSchoolHelper::userSchoolId($model->user_id, $olimpiad->year);
                        return DictSchoolsHelper::schoolName($school) ?? DictSchoolsHelper::preSchoolName($school);
                    }
                ],
       [
           'label' => 'Номинация',
           'format' => 'raw',
           'value' => function ($model) {
              if($model instanceof \testing\models\TestAttempt) {
                  return $model->test->olympic_profile_id ? $model->test->olympicSpecialityProfile->fullName : '';
              }
              return '';
           }
       ],
       [
           'attribute' => 'mark',
           'value' => function ($model) {
               return $model->mark ? $model->mark : 0;
           }
       ],
   ];
} else {
    $columns = [['label' => 'ФИО участника',
        'format' => 'raw',
        'value' => function ($model)use($olimpiad) {
            return PersonalPresenceAttemptHelper::userOfPlacesForCert($model->user_id,
                $model->reward_status, $olimpiad);
        }],
        [
            'label' => 'Название образовательной организации',
            'format' => 'raw',
            'value' => function ($model) use ($olimpiad) {
                $school = UserSchoolHelper::userSchoolId($model->user_id, $olimpiad->year);
                return DictSchoolsHelper::schoolName($school) ?? DictSchoolsHelper::preSchoolName($school);
            }
        ],
        [
            'attribute' => 'mark',
            'value' => function ($model) {
                return $model->mark ? $model->mark : 0;
            }
        ],
    ];
}

?>
<div class="container">
    <div class="row printDiv">
        <h2><?= $olimpiad->name . '. <br/>' . $this->title ?></h2>
        <?= GridView::widget([
            'dataProvider' => $dataProvider,
            'columns' => $columns
        ]);

        ?>
    </div>
</div>

