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
    <h1><?= $this->title ?></h1>
    <div>
        <?php foreach (\modules\dictionary\models\CompetitionList::listTitle() as $value): ?>
        <h2><?= Html::a($value['name'], [$value['url']]) ?></h2>
        <?php endforeach; ?>
        <?php foreach (\modules\dictionary\models\CompetitionList::listTitle(true)  as $key => $value): ?>
            <?php if($key != \dictionary\helpers\DictCompetitiveGroupHelper::EDUCATION_LEVEL_BACHELOR) continue ?>
            <h2><?= Html::a($value['name'], [$value['url']]) ?></h2>
        <?php endforeach; ?>
    </div>
</div>


