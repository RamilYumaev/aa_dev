<?php
namespace backend\widgets\testing;

use yii\base\Widget;
use yii\data\ArrayDataProvider;
use yii\db\Query;

class TestAttemptWidget extends Widget
{
    public $test_id;
    public $olympicId = null;
    /**
     * @var string
     */
    public $view = 'test-attempt/index';
    public $viewPo = 'test-attempt/index_po';

    public function run()
    {
        $query = new Query;
        $query = $query->from("test_attempt")->where('test_id='.$this->test_id)->indexBy('id')->orderBy('mark DESC');
        $dataProvider = new ArrayDataProvider([
            'allModels' => $query->all(),
        ]);

        return $this->render($this->olympicId == 61 ?  $this->viewPo : $this->view, [
            'dataProvider' => $dataProvider,
        ]);
    }
}
