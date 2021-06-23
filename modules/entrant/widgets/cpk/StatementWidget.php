<?php
namespace modules\entrant\widgets\cpk;

use modules\entrant\helpers\CategoryStruct;
use modules\entrant\helpers\StatementHelper;
use modules\entrant\readRepositories\StatementReadRepository;
use yii\base\Widget;
use yii\data\ActiveDataProvider;

class StatementWidget extends Widget
{
    public $view = "statement-new";
    public $category = null;
    public $entrant;
    public $status;

    public function run()
    {
        $query = (new  StatementReadRepository($this->entrant))->readData();
        $query->status($this->status)->orderByCreatedAtDesc();
        if($this->category) {
             $query->andWhere(['special_right'=> $this->category]);
        }
        $dataProvider = new ActiveDataProvider(['query'=> $query, 'pagination' => [
            'pageSize' =>  4,
        ],]);
        return $this->render($this->view, [
            'dataProvider' => $dataProvider,
        ]);
    }

}
