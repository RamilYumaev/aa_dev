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
     * @var boolean
     */
    public $isAdd = true;

    /**
     * @var DictSchoolsReport
     */
    public $model;

    /**
     * @return string
     */
    public function run()
    {
        $searchModel = new DictSchoolsSearch($this->query());
        $dataProvider = $searchModel->search(\Yii::$app->request->queryParams);

        return $this->render($this->viewPath(), [
             'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'school' => $this->model
        ]);
    }

    private function queryDefaultSchool() {
        return DictSchools::find()
            ->countryAndRegion($this->model->school->region_id, $this->model->school->country_id);
    }

    private function query() {
        if ($this->isAdd) {
            return $this->queryDefaultSchool()->notDictSchoolReportId();
        }
        return $this->queryDefaultSchool()->dictSchoolReportId($this->model->id, $this->model->school_id);
    }

    private function viewPath() {
        return $this->isAdd ? 'dict-schools/index-add' : 'dict-schools/index-update';
    }
}
