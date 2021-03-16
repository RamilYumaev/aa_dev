<?php
namespace backend\widgets\testing;

use yii\base\Widget;
use yii\data\ActiveDataProvider;
use yii\db\Query;

class TestAttemptWidget extends Widget
{
    public $test_id;
    /**
     * @var string
     */
    public $view = 'test-attempt/index';

    public function run()
    {
        $query = new Query;
        $query = $query->from("test_attempt")->where('test_id='.$this->test_id)->indexBy('id')->orderBy('mark DESC');
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        return $this->render($this->view, [
            'dataProvider' => $dataProvider,
        ]);
    }
}
