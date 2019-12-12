<?php
namespace olympic\forms\search;

use dictionary\helpers\DictFacultyHelper;
use olympic\helpers\OlympicHelper;
use olympic\models\Olympic;
use yii\base\Model;
use yii\data\ActiveDataProvider;

class OlympicSearch extends Model
{
    public $name, $status;
    protected $_query;

    public function rules()
    {
        return [
            [['status'], 'integer'],
            [['name',], 'safe'],
        ];
    }

    public function __construct($manager = null, $config = [])
    {
        if ($manager) {
            $this->_query = Olympic::find()->manager($manager);
        } else {
            $this->_query = Olympic::find();
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
            'status' => $this->status,
        ]);

        $query
            ->andFilterWhere(['like', 'name', $this->name]);

        return $dataProvider;
    }

    public function attributeLabels(): array
    {
        return Olympic::labels();
    }

    public  function statusList() {
        return OlympicHelper::statusList();
    }
}