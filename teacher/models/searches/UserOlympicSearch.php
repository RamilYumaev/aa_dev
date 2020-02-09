<?php

namespace teacher\models\searches;

use common\auth\models\UserSchool;
use dictionary\helpers\DictSchoolsHelper;
use olympic\helpers\auth\ProfileHelper;
use olympic\helpers\OlympicListHelper;
use olympic\models\OlimpicList;
use olympic\models\UserOlimpiads;
use teacher\helpers\UserTeacherJobHelper;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use yii\data\ArrayDataProvider;
use yii\helpers\ArrayHelper;

class UserOlympicSearch extends Model
{
    public $year;
    public $olympiads_id;
    public $user_id;

    public function rules()
    {
        return [
            [['year'], 'string'],
            [['olympiads_id', 'user_id'], 'integer']
        ];
    }

    /**
     * @param array $params
     * @return ActiveDataProvider
     */
    public function search(array $params): ActiveDataProvider
    {
        $query = $this->find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'o.year' => $this->year,
            'uo.olympiads_id' => $this->olympiads_id,
            'uo.user_id' => $this->user_id,
        ]);
        return $dataProvider;
    }

    protected function find() {
        $query = UserOlimpiads::find()
            ->alias("uo")
            ->innerJoin(OlimpicList::tableName() . ' o',  'uo.olympiads_id =o.id')
            ->select(['uo.user_id', 'uo.olympiads_id', 'uo.id']);
        return $query;
    }

    public function attributeLabels()
    {
        return ['year' => "Учебный год",
                'olympiads_id' => 'Олимпиада',
                'user_id' => 'ФИО Участника',
            ];
    }

}