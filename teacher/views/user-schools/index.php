<?php
use yii\helpers\Html;
/* @var $this yii\web\View */
/* @var $searchModel teacher\models\searches\UserOlympicSearch */
/* @var $dataProvider yii\data\ArrayDataProvider */

$this->title = 'Ученики/студенты';
$this->params['breadcrumbs'][] = $this->title;
?>
<?php if (is_null(\teacher\helpers\UserTeacherJobHelper::columnSchoolId(Yii::$app->user->identity->getId()))) : ?>
    <?= Yii::$app->session->addFlash("warning", "Сначала добавьте данные о Вашей учебной организации")?>
<?php else: ?>
<div class="row">
    <div class="col-md-8 col-md-offset-2">
        <div class="box box-success">
            <div class="box-body">
                <?= $this->render('_search', ['model' => $searchModel]); ?>
            </div>
        </div>
    </div>
    <div class="col-md-12">
        <div class="box box-primary">
            <div class="box-body">
                <?= $this->render('_data', ['dataProvider' => $dataProvider]); ?>
            </div>
        </div>
    </div>
</div>
    <?php endif; ?>