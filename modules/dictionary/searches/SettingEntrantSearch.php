<?php
namespace modules\dictionary\searches;

use modules\dictionary\models\SettingEntrant;
use yii\base\Model;
use yii\data\ActiveDataProvider;

class SettingEntrantSearch extends Model
{
    public  $faculty_id, $is_vi, $form_edu, $edu_level, $finance_edu, $type, $special_right, $datetime_start, $datetime_end;

    public function rules()
    {
        return [
            [['form_edu', 'edu_level',
                'is_vi','type',
                'finance_edu','faculty_id',], 'integer'],
            [['special_right', 'datetime_start', 'datetime_end'], 'safe'],
        ];
    }
    /**
     * @param array $params
     * @return ActiveDataProvider
     */
    public function search(array $params): ActiveDataProvider
    {
        $query = SettingEntrant::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'edu_level' =>  $this->edu_level,
            'finance_edu' => $this->finance_edu,
            'faculty_id' => $this->faculty_id,
            'is_vi' => $this->is_vi,
            'type' => $this->type,
            'form_edu,' => $this->form_edu,
        ]);

        $query
            ->andFilterWhere(['like',  'special_right', $this->special_right])
            ->andFilterWhere(['like','datetime_start' , $this->datetime_start])
            ->andFilterWhere(['like','datetime_end' , $this->datetime_end]);

        return $dataProvider;
    }
}