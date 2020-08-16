<?php
namespace modules\entrant\widgets\cpk;

use modules\entrant\helpers\CategoryStruct;
use modules\entrant\helpers\FileHelper;
use modules\entrant\helpers\StatementHelper;
use modules\entrant\readRepositories\FileReadCozRepository;
use modules\entrant\readRepositories\ProfileFileReadRepository;
use modules\entrant\readRepositories\StatementReadRepository;
use yii\base\Widget;
use yii\data\ActiveDataProvider;

class FileCozWidget extends Widget
{
    public $view = "file-new";
    public $entrant;

    public function run()
    {
        $query = (new FileReadCozRepository($this->entrant))->readData()->andWhere(['files.status'=> FileHelper::STATUS_WALT]);
        $dataProvider = new ActiveDataProvider(['query'=> $query, 'pagination' => [
            'pageSize' =>  15,
        ],]);
        return $this->render($this->view, [
            'dataProvider' => $dataProvider,
        ]);
    }

}
