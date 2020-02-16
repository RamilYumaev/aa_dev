<?php
use dictionary\helpers\DictSchoolsHelper;
/* @var $this yii\web\View */

/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title= "Главная"
?>
<div class="box">
    <div class="box-header">
    </div>
    <div class="box-body">
        <?= \backend\widgets\adminlte\grid\GridView::widget([
            'dataProvider' => $dataProvider,
            'columns' => [
                ['class' => \yii\grid\SerialColumn::class],
                 ['attribute' =>'id_olympic_user',
                   'value' => function (\teacher\models\TeacherClassUser $model) {
                        return $model->getOlympicUserOne()->getFullNameUser();
                   }
                 ],
                [ 'header'=> "Наименование олимпиады (уч. год)",
                        'format' => 'raw',
                    'value' => function (\teacher\models\TeacherClassUser $model) {
                        return $model->getOlympicUserOne()->getOlympicAndYear();
                    }
                ],
                [ 'header'=> "",
                    'format' => 'raw',
                    'value' => function (\teacher\models\TeacherClassUser $model) {
                        $diploma = $model->getOlympicUserOne()->olympicUserDiploma();
                        if ($diploma) {
                            $urlFrontend = \yii\helpers\Url::to('@frontendInfo/gratitude/index?id='. $model->id);
                            return \yii\helpers\Html::a("Благодарность", $urlFrontend,
                                ['class' => 'btn btn-info']);
                        }
                        return "";
                    }
                ],
            ]
        ]); ?>
    </div>
</div>
