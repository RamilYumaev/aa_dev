<?php
namespace modules\entrant\searches;

use modules\dictionary\models\JobEntrant;
use modules\entrant\readRepositories\StatementCgReadRepository;
use yii\base\Model;
use yii\data\ActiveDataProvider;

class StatementCgSearch extends  Model
{
    public  $cg_id;

    private $jobEntrant;

    public function __construct(JobEntrant $entrant, $config = [])
    {
        $this->jobEntrant = $entrant;
        parent::__construct($config);
    }

    public function rules()
    {
        return [
            [['cg_id'], 'integer'],
        ];
    }
    /**
     * @param array $params
     * @return ActiveDataProvider
     */
    public function search(array $params): ActiveDataProvider
    {
        $query = (new StatementCgReadRepository($this->jobEntrant))->readData();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'cg_id' => $this->cg_id
        ]);

        $query->select('cg_id')->groupBy('cg_id');

        return $dataProvider;
    }
}