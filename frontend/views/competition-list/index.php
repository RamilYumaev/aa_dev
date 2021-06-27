<?php
/**
 * @var $this View
 */
use yii\helpers\Html;
use yii\web\View;

$this->title = "Конкурсные списки";

$this->params['breadcrumbs'][] = $this->title;

?>

<div class="container">
    <div class="row">
        <div class=" col-xs-offset-1 col-xs-10 col-md-offset-3 col-md-6  ">
    <h1 style="margin-top: 54px; text-align: center"><?= $this->title ?></h1>
    <div style="margin: 0 auto; margin-top: 30px;">
        <?php foreach (\modules\dictionary\models\CompetitionList::listTitle() as $value): ?>
        <h3 style="text-size: 25px; font-weight: 100" ><?= Html::a($value['name'], [$value['url']]) ?></h3>
        <?php endforeach; ?>
        <?php foreach (\modules\dictionary\models\CompetitionList::listTitle(true)  as $key => $value): ?>
            <?php if($key != \dictionary\helpers\DictCompetitiveGroupHelper::EDUCATION_LEVEL_BACHELOR) continue ?>
            <h3><?= Html::a($value['name'], [$value['url']]) ?></h3>
        <?php endforeach; ?>
    </div>
    </div>
    </div>
</div>


