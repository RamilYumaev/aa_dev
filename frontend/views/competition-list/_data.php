<?php
/**
 * @var $faculty
 * @var $cg dictionary\models\DictCompetitiveGroup
 * @var $title
 * @var $eduLevel
 */

$this->title = $title;

$this->params['breadcrumbs'][] = ['label' => 'Конкурсные списки', 'url' => ['competition-list/index']];
$this->params['breadcrumbs'][] = $this->title;

use dictionary\helpers\DictCompetitiveGroupHelper; ?>
<div>
    <h1><?= $this->title ?></h1>
    <?php foreach ($faculty as $item):
        $cgs = $item->faculty->getCg()->contractOnly()->edulevel($eduLevel)->foreignerStatus(false)
        ->tpgu(false);
        if($eduLevel == DictCompetitiveGroupHelper::EDUCATION_LEVEL_GRADUATE_SCHOOL) {
            $cgs->select(['speciality_id','faculty_id','education_form_id'])
                ->groupBy(['speciality_id','faculty_id','education_form_id']);
        }?>
        <h3><?= $item->faculty->full_name?></h3>
        <table class="table">
            <tr>
                <th>Код и наименование направления подготовки</th>
                <th>Форма обучения</th>
                <th>Конкурсные списки</th>
            </tr>
            <?php foreach ($cgs->all() as $cg): ?>
            <tr>
                <th><?=$cg->specialty->codeWithName?> <?=$cg->getSpecialisationName()?></th>
                <th><?= $cg->formEdu ?></th>
                <th><?= \frontend\widgets\competitive\ButtonWidget::widget(['cgContract'=> $cg, 'eduLevel'=> $eduLevel]) ?></th>
            </tr>
            <?php endforeach; ?>
        </table>
    <?php endforeach; ?>
</div>
