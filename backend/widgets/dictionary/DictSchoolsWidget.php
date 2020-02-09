<?php
namespace backend\widgets\dictionary;

use dictionary\forms\search\DictSchoolsSearch;
use dictionary\models\DictSchools;
use dictionary\models\DictSchoolsReport;
use yii\base\Widget;
use yii\db\BaseActiveRecord;

class DictSchoolsWidget extends Widget
{

    /**
     * @var DictSchoolsReport
     */
    public $model;

    /**
     * @var string
     */
    public $view = 'dict-schools/index';

    /**
     * @return string
     */
    public function run()
    {
        $query = DictSchools::find()->countryAndRegion($this->model->region_id, $this->model->country_id);

        $searchModel = new DictSchoolsSearch($query);
        $dataProvider = $searchModel->search(\Yii::$app->request->queryParams);

        return $this->render($this->view, [
             'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'school_id' => $this->model->id
        ]);
    }
}
