<?php

namespace modules\literature\forms\search;

use borales\extensions\phoneInput\PhoneInputValidator;
use modules\literature\models\PersonsLiterature;
use yii\base\Model;
use yii\data\ActiveDataProvider;

class PersonsSearch extends Model
{
    public $email,
        $phone,
        $fio;

    public function rules()
    {
        return [
            [['email', 'phone' ,'fio'], 'safe'],
            [['phone'], PhoneInputValidator::class],
        ];
    }

    /**
     * @param array $params
     * @return ActiveDataProvider
     */
    public function search(array $params): ActiveDataProvider
    {
        $query = PersonsLiterature::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere(['like', 'fio', $this->fio]);
        $query->andFilterWhere(['like', 'phone', $this->phone]);
        $query->andFilterWhere(['like', 'email', $this->email]);

        return $dataProvider;
    }
}