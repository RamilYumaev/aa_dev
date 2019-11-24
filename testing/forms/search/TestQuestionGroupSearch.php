<?php


namespace testing\forms\search;


use testing\helpers\TestQuestionGroupHelper;
use testing\models\TestQuestionGroup;
use yii\base\Model;
use yii\data\ActiveDataProvider;

class TestQuestionGroupSearch extends Model
{
    public $name, $olimpic_id, $year;
    protected $_query;

    public function rules()
    {
        return [
            [['olimpic_id', ], 'integer'],
            [['name','year'], 'safe'],
        ];
    }

    public function __construct($olympic_id = null, $config = [])
    {
        if ($olympic_id) {
            $this->_query = TestQuestionGroup::find()->where(['olimpic_id' => $olympic_id])->orderBy(['year'=>SORT_DESC]);
        } else {
            $this->_query = TestQuestionGroup::find();
        }
        parent::__construct($config);
    }

    /**
     * @param array $params
     * @return ActiveDataProvider
     */
    public function search(array $params): ActiveDataProvider
    {
        $query = $this->_query;

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'olimpic_id' => $this->olimpic_id,
        ]);

        $query
            ->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'year', $this->year]);

        return $dataProvider;
    }

    public function attributeLabels(): array
    {
        return TestQuestionGroup::labels();
    }

    public function olympicList(): array
    {
        return TestQuestionGroupHelper::testQuestionGroupOlympicNameList();
    }

    public function yearList(): array
    {
        return TestQuestionGroupHelper::testQuestionGroupYearList();
    }


}