<?php

namespace teacher\models\searches;

use common\auth\models\UserSchool;
use dictionary\helpers\DictSchoolsHelper;
use olympic\helpers\OlympicListHelper;
use olympic\models\UserOlimpiads;
use teacher\helpers\UserTeacherJobHelper;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use yii\data\ArrayDataProvider;
use yii\helpers\ArrayHelper;

class UserOlympicSearch extends Model
{
    public $school_id;
    public $olympiads_id;

    public function rules()
    {
        return [
            [['school_id', 'olympiads_id'], 'integer']
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
            'us.school_id' => $this->school_id,
            'uo.olympiads_id' => $this->olympiads_id,
        ]);
        return $dataProvider;
    }

    protected function find() {
        $query = UserOlimpiads::find()
            ->alias("uo")
            ->innerJoin(UserSchool::tableName() . ' us', 'us.user_id = uo.user_id')
            ->andWhere(['us.school_id' => UserTeacherJobHelper::columnSchoolId()])
            ->select(['uo.user_id', 'uo.olympiads_id', 'uo.status',
                'uo.id','us.school_id']);

        return $query;
    }

    public function attributeLabels()
    {
        return ['school_id' => "Учебная организация",
                'olympiads_id' => 'Олимпиада'];
    }

    public function listOlympic()
    {
        return  ArrayHelper::map($this->find()->asArray()->all(), 'olympiads_id', function ($array) {
            return OlympicListHelper::olympicAndYearName($array['olympiads_id']);
        });
    }

    public function listSchool()
    {
        return  ArrayHelper::map($this->find()->asArray()->all(), 'school_id', function ($array) {
            return DictSchoolsHelper::schoolName($array['school_id']);
        });
    }


}