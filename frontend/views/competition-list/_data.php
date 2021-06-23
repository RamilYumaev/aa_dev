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
<div class="container">
<div class="row">
    <h1 style="text-align: center; margin-top: 40px;"><?= $this->title ?></h1>
    <div style="margin-top: 35px;">
    <?php foreach ($faculty as $item):
        $cgs = $item->faculty->getCg()->contractOnly()->edulevel($eduLevel)->foreignerStatus(false)
        ->tpgu(false)->currentAutoYear();
        if($eduLevel == DictCompetitiveGroupHelper::EDUCATION_LEVEL_GRADUATE_SCHOOL) {
            $cgs->select(['speciality_id','faculty_id','education_form_id'])
                ->groupBy(['speciality_id','faculty_id','education_form_id']);
        }?>
        <h3 style="margin-top: 40px"><?= $item->faculty->full_name?></h3>
        <table class="table">
            <tr>
                <th style="width: 760px">Код и наименование направления подготовки</th>
                <th>Форма обучения</th>
                <th>Конкурсные списки</th>
            </tr>
            <?php foreach ($cgs->all() as $cg): ?>
            <tr>
                <th style="font-weight: 100"><?=$cg->specialty->codeWithName?> <?=$cg->getSpecialisationName() .($eduLevel ==  DictCompetitiveGroupHelper::EDUCATION_LEVEL_SPO ? "(для " . $cg->spo_class . " классов)": '') ?> </th>
                <th style="font-weight: 100"><?= $cg->formEdu ?></th>
                <th style="font-weight: 100"><?= \frontend\widgets\competitive\ButtonWidget::widget(['cgContract'=> $cg, 'eduLevel'=> $eduLevel]) ?></th>
            </tr>
            <?php endforeach; ?>
        </table>
    <?php endforeach; ?>
    </div>
    </div>
</div>
