<?php
use yii\helpers\Html;
use dictionary\helpers\DictCompetitiveGroupHelper;
/* @var $this yii\web\View */
/* @var $userCg yii\db\BaseActiveRecord */
/* @var $userId integer */

?>
<table class="table table-bordered">
    <?php foreach ($userCg as  $cg) /* @var $cg dictionary\models\DictCompetitiveGroup */ :?>
        <tr>
            <th rowspan="2">#</th>
            <th colspan="4"><center><?= $cg->faculty->full_name ?></center></th>
            <th colspan="2">Вид финансирования</th>
        </tr>
        <tr>
            <td>Направление подготовки</td>
            <td>Образовательная программма</td>
            <td>Форма обучения</td>
            <td>Основание приема</td>
            <td>Федеральный бюджет</td>
            <td>Платное обучение</td>
        </tr>
        <?php
        foreach (DictCompetitiveGroupHelper::facultySpecialityAllUser(
            $userId,
            $cg->faculty->id,
            $cg->speciality_id) as $key => $cgUser) /* @var $cgUser dictionary\models\DictCompetitiveGroup */ :
            $finance = DictCompetitiveGroupHelper::financeUser($userId,
                $cgUser->faculty_id, $cgUser->speciality_id,
                $cgUser->education_form_id,
                $cgUser->specialization_id);
            ?>
            <tr>
                <td><?=++$key?></td>
                <td><?= $cgUser->specialty->code." ".$cgUser->specialty->name ?></td>
                <td><?= $cgUser->specialization->name ?? "" ?></td>
                <td><?= DictCompetitiveGroupHelper::formName($cgUser->education_form_id) ?></td>
                <td></td>
                <td><h4><?= in_array(DictCompetitiveGroupHelper::FINANCING_TYPE_BUDGET, $finance) ? "X" : ""?></h4></td>
                <td><h4><?= in_array(DictCompetitiveGroupHelper::FINANCING_TYPE_CONTRACT, $finance) ? "X" : ""?></h4></td>
            </tr>
        <?php endforeach; ?>
        <tr><td colspan="7"><?= Html::a('Скачать', '#', ['class' => 'btn btn-large btn-primary pull-right'])?></td></tr>
    <?php endforeach; ?>
</table>
