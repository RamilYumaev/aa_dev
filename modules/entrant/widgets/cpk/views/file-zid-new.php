<?php

use yii\grid\ActionColumn;
use modules\entrant\helpers\DateFormatHelper;
use backend\widgets\adminlte\grid\GridView;
use modules\entrant\helpers\SelectDataHelper;
use modules\entrant\helpers\StatementHelper;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

?>
<?= GridView::widget([
    'dataProvider' => $dataProvider,
    'columns' => [
        [
            'value'=> 'statementIndividualAchievement.profileUser.fio'
        ],
        [
            'value'=> 'statementIndividualAchievement.numberStatement'
        ],
        [
            'value'=> 'userIndividualAchievements.dictOtherDocument.typeName'
        ],
         ['value' => function (\modules\entrant\models\StatementIa $model) {
          return  Html::a("Просмотр",  ['data-entrant/statement-individual-achievements/view', 'id' => $model->statement_individual_id]
             , ['class' =>  'btn btn-info']);

        },
            'format' => "raw",
        ]

    ]
]); ?>
