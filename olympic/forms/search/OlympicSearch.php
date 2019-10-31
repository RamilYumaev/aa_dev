<?php
namespace olympic\forms\search;

use dictionary\helpers\DictFacultyHelper;
use olympic\helpers\OlympicHelper;
use olympic\models\Olympic;
use yii\base\Model;
use yii\data\ActiveDataProvider;

class OlympicSearch extends Model
{
    public $name, $form_of_passage, $faculty_id;

    public function rules()
    {
        return [
            [['form_of_passage', 'faculty_id'], 'integer'],
            [['name',], 'safe'],
        ];
    }

    /**
     * @param array $params
     * @return ActiveDataProvider
     */
    public function search(array $params): ActiveDataProvider
    {
        $query = Olympic::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'form_of_passage' => $this->form_of_passage,
            'faculty_id' => $this->faculty_id
        ]);

        $query
            ->andFilterWhere(['like', 'name', $this->name]);

        return $dataProvider;
    }

    public function attributeLabels(): array
    {
        return Olympic::labels();
    }

    public function formOfPassage()
    {
        return OlympicHelper::formOfPassage();
    }

    public function facultyList(): array
    {
        return DictFacultyHelper::facultyList();
    }
}