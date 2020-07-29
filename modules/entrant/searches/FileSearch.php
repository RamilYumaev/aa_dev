<?php
namespace modules\entrant\searches;

use modules\dictionary\models\JobEntrant;
use modules\entrant\readRepositories\FileReadCozRepository;
use modules\entrant\readRepositories\ProfileFileReadRepository;
use modules\entrant\readRepositories\ProfileStatementReadRepository;
use yii\base\Model;
use yii\data\ActiveDataProvider;

class FileSearch extends  Model
{
    public $model, $status, $date_from, $date_to, $user_id;
    private $jobEntrant;

    public function __construct(JobEntrant $entrant, $config = [])
    {
        $this->jobEntrant = $entrant;
        parent::__construct($config);
    }

    public function rules()
    {
        return [
            [['user_id', 'status'], 'integer'],
            [[ 'model',], 'safe'],
            [['date_from', 'date_to'], 'date', 'format' => 'php:Y-m-d'],
        ];
    }
    /**
     * @param array $params
     * @return ActiveDataProvider
     */
    public function search(array $params): ActiveDataProvider
    {
        $query = (new FileReadCozRepository($this->jobEntrant))->readData()->orderBy(['files.updated_at' => SORT_DESC]);;
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'files.user_id'=>$this->user_id,
            'model'=>$this->model,
            'files.status'=> $this->status,
        ]);

        $query
            ->andFilterWhere(['>=', 'files.updated_at', $this->date_from ? strtotime($this->date_from . ' 00:00:00') : null])
            ->andFilterWhere(['<=', 'files.updated_at', $this->date_to ? strtotime($this->date_to . ' 23:59:59') : null]);

        return $dataProvider;
    }


}