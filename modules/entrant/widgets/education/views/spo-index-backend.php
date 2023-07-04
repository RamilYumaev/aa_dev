<?php

use backend\widgets\adminlte\Box;
use modules\entrant\helpers\BlockRedGreenHelper;
use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model modules\entrant\models\AverageScopeSpo */
?>
<?php if ($model) : ?>
    <?php Box::begin(
        [
            "header" => "Средний балл аттестата",
            "type" => Box::TYPE_WARNING,
            "icon" => 'book',
            "filled" => true,]) ?>

    <?= DetailView::widget([
        'options' => ['class' => 'table table-bordered detail-view'],
        'model' => $model,
        'attributes' => ['number_of_threes', 'number_of_fours', 'number_of_fives', 'average']
    ]) ?>
    <?php Box::end() ?>
<?php endif; ?>

