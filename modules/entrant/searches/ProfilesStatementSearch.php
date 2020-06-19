<?php
namespace modules\entrant\searches;

use modules\dictionary\models\JobEntrant;
use modules\entrant\readRepositories\ProfileStatementReadRepository;
use yii\base\Model;
use yii\data\ActiveDataProvider;

class ProfilesStatementSearch extends  Model
{
    public $last_name, $first_name, $patronymic, $gender, $country_id, $region_id, $phone, $user_id;
    private $jobEntrant;
    private $type;

    public function __construct(JobEntrant $entrant, $type, $config = [])
    {
        $this->type = $type;
        $this->jobEntrant = $entrant;
        parent::__construct($config);
    }

    public function rules()
    {
        return [
            [['gender', 'country_id', 'region_id', 'phone', 'user_id'], 'integer'],
            [['last_name', 'first_name', 'patronymic',], 'safe'],
        ];
    }
    /**
     * @param array $params
     * @return ActiveDataProvider
     */
    public function search(array $params): ActiveDataProvider
    {
        $query = (new ProfileStatementReadRepository($this->jobEntrant))->readData($this->type);
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'statement.user_id'=>$this->user_id,
            'gender'=>$this->gender,
            'country_id'=> $this->country_id,
            'region_id' =>$this->region_id,
        ]);

        $query
            ->andFilterWhere(['like', 'last_name',  $this->last_name])
            ->andFilterWhere(['like', 'first_name', $this->first_name])
            ->andFilterWhere(['like', 'phone', $this->phone])
            ->andFilterWhere(['like', 'patronymic', $this->patronymic]);

        return $dataProvider;
    }


}