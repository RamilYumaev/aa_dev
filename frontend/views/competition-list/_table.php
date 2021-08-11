<?php
/**
 * @var $faculty
 * @var $cg dictionary\models\DictCompetitiveGroup
 * @var $cgs \yii\db\ActiveQuery
 * @var $title
 * @var $item
 * @var $isFaculty
 * @var $eduLevel
 */
use dictionary\helpers\DictCompetitiveGroupHelper;
if($isFaculty) {
$this->title = $facultyName;
$this->params['breadcrumbs'][] = ['label' => 'Конкурсные списки', 'url' => ['competition-list/index']];
$this->params['breadcrumbs'][] = ['label' => $title, 'url' => [$url]];
$this->params['breadcrumbs'][] = $this->title;
}

?>
<table class="table">
    <tr>
        <th style="width: 760px">Код и наименование направления подготовки</th>
        <th>Форма обучения</th>
        <th>Конкурсные списки</th>
    </tr>
    <?php $cgs = $item->faculty->getCg()->contractOnly()->edulevel($eduLevel)->foreignerStatus(false)
        ->tpgu(false)->currentAutoYear();
    if($eduLevel == DictCompetitiveGroupHelper::EDUCATION_LEVEL_GRADUATE_SCHOOL) {
        $cgs->select(['speciality_id','faculty_id','education_form_id'])
            ->groupBy(['speciality_id','faculty_id','education_form_id']);
    } foreach ($cgs->all() as $cg): ?>
        <tr>
            <th style="font-weight: 100"><?=$cg->specialty->codeWithName?> <?= ($eduLevel ==  DictCompetitiveGroupHelper::EDUCATION_LEVEL_SPO || $eduLevel ==  DictCompetitiveGroupHelper::EDUCATION_LEVEL_GRADUATE_SCHOOL ? "(для " . $cg->spo_class . " классов)": $cg->specialization->name ) ?> </th>
            <th style="font-weight: 100"><?= $cg->formEdu ?></th>
            <th style="font-weight: 100"><?= \frontend\widgets\competitive\ButtonWidget::widget(['cgContract'=> $cg, 'eduLevel'=> $eduLevel]) ?></th>
        </tr>
    <?php endforeach; ?>
</table>
