<?php
namespace modules\entrant\searches;

use modules\entrant\helpers\StatementHelper;
use modules\entrant\models\Statement;
use olympic\models\auth\Profiles;
use yii\base\Model;
use yii\data\ActiveDataProvider;

class ProfilesStatementSearch extends  Model
{
    public $last_name, $first_name, $patronymic, $gender, $country_id, $region_id, $phone;

    public function rules()
    {
        return [
            [['gender', 'country_id', 'region_id', 'phone' ], 'integer'],
            [['last_name', 'first_name', 'patronymic',], 'safe'],
        ];
    }
    /**
     * @param array $params
     * @return ActiveDataProvider
     */
    public function search(array $params): ActiveDataProvider
    {
        $query = Profiles::find()
            ->alias('profiles')
            ->innerJoin(Statement::tableName(), 'statement.user_id=profiles.user_id')
            ->andWhere(['>','statement.status', StatementHelper::STATUS_DRAFT])
            ->orderBy(['statement.updated_at'=> SORT_DESC]);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
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