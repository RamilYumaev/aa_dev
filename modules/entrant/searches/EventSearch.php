<?php
namespace modules\entrant\searches;

use modules\dictionary\models\JobEntrant;
use modules\entrant\models\Event;
use modules\entrant\readRepositories\FileReadCozRepository;
use modules\entrant\readRepositories\ProfileFileReadRepository;
use modules\entrant\readRepositories\ProfileStatementReadRepository;
use yii\base\Model;
use yii\data\ActiveDataProvider;

class EventSearch extends  Model
{
    public  $type, $date, $name_src, $src, $place, $faculty_id, $edu_level, $cg_id, $form_id;

    public function rules()
    {
        return [
            [['type','faculty_id', 'edu_level', 'cg_id', 'form_id'], 'integer'],
            [['date'], 'safe'],
            [['place', 'name_src', 'src'], 'string', 'max' => 255],
        ];
    }
    /**
     * @param array $params
     * @return ActiveDataProvider
     */
    public function search(array $params): ActiveDataProvider
    {
        $query = Event::find()->orderBy(['date' => SORT_DESC]);
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            $query->where('0=1');
            return $dataProvider;
        }

        if ($this->form_id) {
            $query->joinWith(['eventCg', 'eventCg.cg'])->andWhere(['education_form_id' => $this->form_id])->distinct();
        }

        if ($this->cg_id) {
            $query->joinWith(['eventCg', 'eventCg.cg'])->andWhere(['cg_id' => $this->cg_id])->distinct();
        }

        if ($this->edu_level) {
            $query->joinWith(['eventCg', 'eventCg.cg'])->andWhere(['edu_level' => $this->edu_level])->distinct();
        }

        if ($this->faculty_id) {
            $query->joinWith(['eventCg', 'eventCg.cg'])->andWhere(['faculty_id' => $this->faculty_id])->distinct();
        }

        $query->andFilterWhere([
            'type'=>$this->type,
        ]);

        $query
            ->andFilterWhere(['like', 'place', $this->place])
            ->andFilterWhere(['like', 'date', $this->date])
            ->andFilterWhere(['like', 'name_src', $this->name_src]);

        return $dataProvider;
    }


}