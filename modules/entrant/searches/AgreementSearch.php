<?php
namespace modules\entrant\searches;

use modules\entrant\readRepositories\AgreementReadRepository;
use yii\base\Model;
use yii\data\ActiveDataProvider;

class AgreementSearch extends  Model
{
    public  $user_id;
    public  $organization_id, $number;
    public $status;

    public function rules()
    {
        return [
            [['user_id', 'organization_id', ], 'integer'],
            [[ 'number',], 'safe'],
        ];
    }

    public function __construct($status,$config = [])
    {
        $this->status = $status;
        parent::__construct($config);
    }

    /**
     * @param array $params
     * @return ActiveDataProvider
     */

    public function search(array $params): ActiveDataProvider
    {
        $query = (new AgreementReadRepository())->readData();

        $dataProvider = new ActiveDataProvider(['query' => $query]);


        if(!is_null($this->status)) {
            $query->status($this->status);
        }
        $this->load($params);

        if (!$this->validate()) {
            $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere(['agreement.user_id' => $this->user_id]);
        $query->andFilterWhere(['organization_id' => $this->organization_id]);

        $query
            ->andFilterWhere(['like', 'number',  $this->number]);

        return $dataProvider;
    }


}