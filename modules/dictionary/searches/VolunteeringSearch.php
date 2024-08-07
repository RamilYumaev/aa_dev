<?php
namespace modules\dictionary\searches;

use modules\dictionary\models\Volunteering;
use yii\base\Model;
use yii\data\ActiveDataProvider;

class VolunteeringSearch extends  Model
{
    public  $clothes_type, $clothes_size, $job_entrant_id, $faculty_id, $experience,
        $note, $form_edu, $course_edu, $conditions_of_work, $finance_edu, $number_edu, $desire_work, $is_reception;

    public function rules()
    {
        return [
            [['form_edu', 'course_edu',
                'experience',
                'is_reception',
                'finance_edu',
                'conditions_of_work',
                'job_entrant_id', 'faculty_id', 'clothes_type',], 'integer'],
            [['number_edu','clothes_size', 'desire_work'], 'safe'],
        ];
    }
    /**
     * @param array $params
     * @return ActiveDataProvider
     */
    public function search(array $params): ActiveDataProvider
    {
        $query = Volunteering::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'job_entrant_id' => $this->job_entrant_id,
            'course_edu' =>  $this->course_edu,
            'finance_edu' => $this->finance_edu,
            'faculty_id' => $this->faculty_id,
            'experience' => $this->experience,
            'clothes_type' => $this->clothes_type,
            'clothes_size' => $this->clothes_size,
            'form_edu' => $this->form_edu,
            'is_reception' => $this->is_reception,
            'conditions_of_work' => $this->conditions_of_work
        ]);


        $query
            ->andFilterWhere(['like', 'number_edu', $this->number_edu])
        ->andFilterWhere(['like','desire_work' , $this->desire_work]);

        return $dataProvider;
    }

}