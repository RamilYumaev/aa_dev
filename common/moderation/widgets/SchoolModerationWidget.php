<?php

namespace common\moderation\widgets;

use common\user\search\SchoolSearch;
use Yii;
use yii\base\Widget;

class SchoolModerationWidget extends Widget
{
    public $id;
    public function run()
    {
        $searchModel = new SchoolSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('search/index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'id' => $this->id,
        ]);
    }
}
