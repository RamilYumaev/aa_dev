<?php
/* @var $this yii\web\View */
/* @var $model teacher\models\searches\UserOlympicSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

use yii\helpers\Html;
use olympic\models\UserOlimpiads;

?>
<?= \backend\widgets\adminlte\grid\GridView::widget([
    'dataProvider' => $dataProvider,
    'columns' => [
        ['class' => \yii\grid\SerialColumn::class],
        ['header' => "ФИО участника",
            'format' => "raw",
            'value' => function (UserOlimpiads $model) {
                return $model->getFullNameUserOrTeacher($model->user_id);
            }
        ],
        ['header' => "Олимпиадв",
            'value' => function (UserOlimpiads $model) {
                return  $model->olympicAndYear;
            }
        ],
        ['header' => "Учебная организация",
            'value' => function (UserOlimpiads $model) {
                return  $model->schoolUser;
            }
        ],
        ['header' => "Класс/курс",
            'value' => function (UserOlimpiads $model) {
                return $model->classUser;
            }
        ],
        ['header' => "Призер/Сертификат",
            'value' => function (UserOlimpiads $model) {
                $diploma = $model->olympicUserDiploma();
                if ($diploma) {
                    return "Да";
                }
                return "Нет";
            }
        ],
        ['value' => function (UserOlimpiads $model) {
               $userTeacherClass = \teacher\helpers\TeacherClassUserHelper::find($model->id);
                if (is_null($userTeacherClass)) {
                    return Html::a("Подтвердить",
                        ['schools-setting/send-user', 'id' => $model->id], [
                            'data-method' => 'post', 'class' => 'btn btn-info', 'data-confirm' => 'Вы уверены, что это  Ваш ученик/студент и хотите отправить
                        письмо с подтверждением?']);
                } else {
                   return \teacher\helpers\TeacherClassUserHelper::statusName($userTeacherClass->status);
                }
            },
            'format' => 'raw'
        ],
    ]
]); ?>

