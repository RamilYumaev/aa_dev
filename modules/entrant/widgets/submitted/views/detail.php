<?php
/* @var $this yii\web\View */
/* @var $submitted modules\entrant\models\SubmittedDocuments */
/* @var $userCg yii\db\BaseActiveRecord */
/* @var $userId integer */
/* @var $finance integer */
/* @var $formCategory integer */

use dictionary\helpers\DictCompetitiveGroupHelper;
use yii\helpers\Html;
$formName = ($formCategory == DictCompetitiveGroupHelper::FORM_EDU_CATEGORY_1 ?
    "" : "(заочная форма обучения)");
?>
<?php if($userCg) : ?>
<div class="row">
    <div class="col-md-12">
        <div class="mt-20">
            <?php if($submitted): ?>
                <h3>Заявления об участии в конкурсе <?= $formName ?> / <?= DictCompetitiveGroupHelper::financingTypeName($finance)?></h3>
                <div id="compact">
                    <table class="table table-bordered">
                        <tr>
                            <th>#</th>
                            <th>Факультет</th>
                            <th>Направление подготовки</th>
                            <th>Уровень образования</th>
                            <th>Основание приема</th>
                        </tr>
                        <?php foreach ($userCg as $key => $cg) /* @var $cg dictionary\models\DictCompetitiveGroup */ :?>
                            <tr>
                                <td><?= ++$key ?></td>
                                <td><?= $cg->faculty->full_name ?></td>
                                <td><?= $cg->specialty->code." ".$cg->specialty->name ?></td>
                                <td><?= DictCompetitiveGroupHelper::eduLevelName($cg->edu_level) ?></td>
                                <td><?= DictCompetitiveGroupHelper::specialRightName($cg->special_right_id) ?></td>
                            <tr>
                            <tr>
                                <td colspan="7">
                                    <?= \modules\entrant\widgets\statement\StatementWidget::widget([
                                        'facultyId' => $cg->faculty_id,
                                        'specialityId'=> $cg->speciality_id,
                                        'specialRight' =>$cg->special_right_id,
                                        'eduLevel' =>$cg->edu_level,
                                        'formCategory'=> $formCategory,
                                        'userId' => Yii::$app->user->identity->getId(),
                                        'finance' => $cg->financing_type_id,
                                           ])?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </table>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>
<?php endif; ?>

