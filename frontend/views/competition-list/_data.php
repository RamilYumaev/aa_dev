<?php
/**
 * @var $faculty
 * @var $cg dictionary\models\DictCompetitiveGroup
 * @var $title
 * @var $isFaculty
 * @var $eduLevel
 */

$this->title = $title;
if(!$isFaculty) {
$this->params['breadcrumbs'][] = ['label' => 'Конкурсные списки', 'url' => ['competition-list/index']];
$this->params['breadcrumbs'][] = $this->title;
}
use dictionary\helpers\DictCompetitiveGroupHelper;
use yii\helpers\Html; ?>
<div class="container">
    <div class="row">
        <h1 style="text-align: center; margin-top: 40px;"><?= $isFaculty ? $isFaculty->full_name : $this->title?></h1>
        <div style="margin-top: 35px;">
        <?php foreach ($faculty as $item):?>
            <?php if ($eduLevel == DictCompetitiveGroupHelper::EDUCATION_LEVEL_BACHELOR && !$item->faculty->filial): ?>
                <?php if($isFaculty): ?>
                    <?= $this->render('_table', ['item'=> $item, 'facultyName' =>$item->faculty->full_name,'eduLevel' => $eduLevel, 'url' => 'bachelor', 'title' => $title, 'isFaculty'=>$isFaculty])?>
                <?php else: ?>
                    <div style='font-weight: 100; font-size: 24px'><?=  Html::a($item->faculty->full_name,['bachelor', 'faculty'=> $item->faculty->id])?></div>
                <?php endif ?>
            <?php elseif ($eduLevel == DictCompetitiveGroupHelper::EDUCATION_LEVEL_MAGISTER): ?>
                <?php if($isFaculty): ?>
                    <?= $this->render('_table', ['item'=> $item, 'facultyName' =>$item->faculty->full_name,'eduLevel' => $eduLevel, 'url' => 'magistracy', 'title' => $title, 'isFaculty'=>$isFaculty])?>
                <?php else: ?>
                    <div style='font-weight: 100; font-size: 24px'><?=  Html::a($item->faculty->full_name,['magistracy', 'faculty'=> $item->faculty->id])?></div>
                <?php endif ?>
            <?php elseif ($eduLevel == DictCompetitiveGroupHelper::EDUCATION_LEVEL_GRADUATE_SCHOOL): ?>
                <?php if($isFaculty): ?>
                    <?= $this->render('_table', ['item'=> $item, 'facultyName' =>$item->faculty->full_name,'eduLevel' => $eduLevel, 'url' => 'graduate', 'title' => $title, 'isFaculty'=>$isFaculty])?>
                <?php else: ?>
                    <div style='font-weight: 100; font-size: 24px'><?=  Html::a($item->faculty->full_name,['graduate', 'faculty'=> $item->faculty->id])?></div>
                <?php endif ?>
            <?php else : ?>
                <h3 style="margin-top: 40px"><?= $item->faculty->full_name?></h3>
                <?= $this->render('_table', ['item'=> $item,'eduLevel' => $eduLevel])?>
            <?php endif; ?>
        <?php endforeach; ?>
        </div>
    </div>
</div>
