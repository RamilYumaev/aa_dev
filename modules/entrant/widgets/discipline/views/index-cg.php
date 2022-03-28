<?php
use dictionary\models\DictCompetitiveGroup;
use modules\entrant\models\UserDiscipline;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $exams array */
/* @var $userDiscipline modules\entrant\models\UserDiscipline */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $userId integer */
/* @var $cg DictCompetitiveGroup */
/* @var $disciplineSpo */
/* @var $cgs */



?>
<div class="row">
    <div class="col-md-12">
        <div class="p-30">
            <table class="table">
                <tr>
                    <th>#</th>
                    <th>Конкурсная группа</th>
                    <th>Заменяемая дисциплина</th>
                    <th></th>
                </tr>
                <?php $a = 0; foreach ($cgs as $cg): ?>
                <tr>
                    <td><?= ++ $a ?></td>
                    <td><?= $cg->getFullNameCg() ?></td>
                    <td>
                        <table class="table">
                            <tr>
                                <th>Вступительное испытание</th>
                                <th>Ваша информация</th>
                                <th>#</th>
                            </tr>
                            <tr>
                                <?php foreach ($cg->getExaminations()->andWhere(['spo_discipline_id' => $disciplineSpo])->all() as $exam):
                                    $userDiscipline = UserDiscipline::find()->user($userId)->discipline($exam->discipline_id)->one(); ?>
                                    <td><?= $exam->discipline->name ?> </td>
                                    <td><?= $userDiscipline ? ($userDiscipline->dictDisciplineSelect->name." / ". $userDiscipline->getNameShortType()." / ".$userDiscipline->year. ' / '.$userDiscipline->mark) : "Нет данных" ?> </td>
                                    <td><?= Html::a('Уточнение',['user-discipline/correction', 'discipline' => $exam->discipline_id, 'spo'=> $disciplineSpo]) ?></td>
                                <?php endforeach; ?>
                            </tr>
                        </table>
                    </td>
                </tr>
                <?php endforeach; ?>
            </table>
        </div>
    </div>
</div>
