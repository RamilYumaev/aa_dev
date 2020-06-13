<?php
namespace modules\entrant\searches;

use modules\entrant\models\Agreement;
use modules\entrant\models\UserAis;
use yii\base\Model;
use yii\data\ActiveDataProvider;

class AgreementSearch extends  Model
{
    public  $user_id;

    public function rules()
    {
        return [
            [['user_id'], 'integer'],
        ];
    }
    /**
     * @param array $params
     * @return ActiveDataProvider
     */
    public function search(array $params): ActiveDataProvider
    {
        $query = Agreement::find()->alias('agreement');

        $dataProvider = new ActiveDataProvider(['query' => $query]);

        $this->load($params);

        if (!$this->validate()) {
            $query->where('0=1');
            return $dataProvider;
        }
       // $query->innerJoin(UserAis::tableName() . ' ais', 'ais.user_id = agreement.user_id');

        $query->andFilterWhere(['agreement.user_id' => $this->user_id]);

        return $dataProvider;
    }

    public function attributeLabels()
    {
        return [
            'user_id'=> "Абитуриент",
        ];
    }




}