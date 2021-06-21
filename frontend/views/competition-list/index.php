<?php
/**
 * @var $this View
 */
use yii\helpers\Html;
use yii\web\View;

$this->title = "Конкурсные списки";

$this->params['breadcrumbs'][] = $this->title;

?>

<div>
    <h1 style="margin-top: 54px; text-align: center"><?= $this->title ?></h1>
    <div style="margin: 0 auto; margin-top: 30px; width: 580px; ">
        <?php foreach (\modules\dictionary\models\CompetitionList::listTitle() as $value): ?>
        <h3 style="text-size: 25px; font-weight: 100" ><?= Html::a($value['name'], [$value['url']]) ?></h2>
        <?php endforeach; ?>
        <?php foreach (\modules\dictionary\models\CompetitionList::listTitle(true)  as $key => $value): ?>
            <?php if($key != \dictionary\helpers\DictCompetitiveGroupHelper::EDUCATION_LEVEL_BACHELOR) continue ?>
            <h3><?= Html::a($value['name'], [$value['url']]) ?></h2>
        <?php endforeach; ?>
    </div>
</div>


