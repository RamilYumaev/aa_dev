<?php

use backend\widgets\adminlte\Box;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $userId integer */

?>
<?php Box::begin(
    [
        "header" => "Иностранные языки, которые изучили или изучаете",
        "type" => Box::TYPE_WARNING,
        "collapsable" => true,
        "filled" => true,]) ?>
            <?= \yii\grid\GridView::widget([
                'tableOptions' => ['class' => 'table  table-bordered'],
                'dataProvider' => $dataProvider,
                'columns' => [
                    ['attribute' => 'language_id', 'value' => 'dictLanguage.name'],
                ],
            ]) ?>
<?php Box::end(); ?>

