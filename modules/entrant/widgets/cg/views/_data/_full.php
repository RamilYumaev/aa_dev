<?php
use yii\helpers\Html;
use dictionary\helpers\DictCompetitiveGroupHelper;
/* @var $this yii\web\View */
/* @var $userCg yii\db\BaseActiveRecord */
/* @var $userId integer */

?>
<table class="table table-bordered">
    <?php foreach ($userCg as  $cg) /* @var $cg dictionary\models\DictCompetitiveGroup */:
        $isCollage =$cg->faculty-> isCollage();?>
        <tr>
            <th rowspan="2">#</th>
            <th colspan="<?= $isCollage ? 4 : 5?>"><center><?= $cg->faculty->full_name ?></center></th>
            <th colspan="2">Вид финансирования</th>
        </tr>
        <tr>
            <td>Направление подготовки</td>
            <?php if (!$isCollage) : ?>
            <td>Образовательная программма</td>
            <?php endif;?>
            <td>Уровень образования</td>
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
                <?php if (!$isCollage) : ?>
                <td><?= $cgUser->specialization->name ?? "" ?></td>
                <?php endif;?>
                <td><?= DictCompetitiveGroupHelper::eduLevelName($cgUser->edu_level) ?></td>
                <td><?= DictCompetitiveGroupHelper::formName($cgUser->education_form_id) ?></td>
                <td><?= DictCompetitiveGroupHelper::specialRightName($cgUser->special_right_id) ?></td>
                <td><h4><?= in_array(DictCompetitiveGroupHelper::FINANCING_TYPE_BUDGET, $finance) ? "X" : ""?></h4></td>
                <td><h4><?= in_array(DictCompetitiveGroupHelper::FINANCING_TYPE_CONTRACT, $finance) ? "X" : ""?></h4></td>
            </tr>
        <?php endforeach; ?>

    <?php endforeach; ?>
</table>
