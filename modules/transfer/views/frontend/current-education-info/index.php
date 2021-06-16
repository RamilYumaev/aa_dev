<?php
/* @var  $this \yii\web\View  */
/* @var $searchModel \modules\transfer\search\CompetitiveGroupSearch
/* @var $form yii\bootstrap\ActiveForm */
use yii\helpers\Html;
use yii\widgets\ListView;
\frontend\assets\modal\ModalAsset::register($this);
$this->title = "Куда осуществляется перевод/восстановление?";
?>
<div class="container">
    <div class="row">
        <div class="col-md-12 mt-30">
            <h1><?= Html::encode($this->title) ?></h1>
        </div>
    </div>
    <div class="row">
        <div class="col-md-4">
            <?php echo $this->render('_search', ['model' => $searchModel]); ?>
        </div>
        <div class="col-md-8">
            <?= ListView::widget([
                'dataProvider' => $dataProvider,
                'itemView' => function (\dictionary\models\DictCompetitiveGroup $model, $key, $index, $widget) {
                    return Html::a( $model->yearConverter()[1]."".$model->getFullNameCg(),
                        ['select', 'id' => $model->id], ['data-pjax' => 'w0'.$model->id, 'data-toggle' => 'modal',
                        'data-target' => '#modal', 'data-modalTitle' => 'Данные']);
                },
            ]) ?>
        </div>
    </div>
</div>