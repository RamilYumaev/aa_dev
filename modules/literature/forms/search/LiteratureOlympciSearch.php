<?php

namespace modules\literature\forms\search;

use modules\literature\models\UserPersonsLiterature;
use yii\base\Model;
use modules\literature\models\LiteratureOlympic;

/**
 * LiteratureOlympciSearch represents the model behind the search form of `modules\literature\models\LiteratureOlympic`.
 */
class LiteratureOlympciSearch extends LiteratureOlympic
{

    public $gender, $phone, $last_name, $first_name, $patronymic, $email, $personal;

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'user_id', 'type', 'status_olympic', 'grade_number', 'grade_performs', 'is_success', 'mark_end', 'mark_end_two', 'mark_end_three', 'mark_end_last', 'status_last', 'is_allergy', 'is_voz', 'is_need_conditions', 'created_at', 'updated_at', 'type_transport_arrival', 'type_transport_departure', 'gender', 'personal'], 'integer'],
            [['birthday', 'phone', 'last_name', 'first_name', 'patronymic', 'email', 'series', 'number', 'date_issue', 'code', 'code_two', 'code_three', 'authority', 'region', 'zone', 'city', 'full_name', 'short_name', 'mark_olympic', 'grade_letter', 'fio_teacher', 'place_work', 'post', 'academic_degree', 'size', 'note_allergy', 'note_conditions', 'note_special', 'date_arrival', 'place_arrival', 'number_arrival', 'date_departure', 'place_departure', 'number_departure', 'photo', 'agree_file', 'hash'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return \yii\db\ActiveQuery
     */
    public function search($params)
    {
        $query = LiteratureOlympic::find()->alias('lo')->joinWith('user.profiles');

        // add conditions that should always apply here
        $this->load($params);


        // grid filtering conditions
        $query->andFilterWhere([
            'lo.id' => $this->id,
            'lo.user_id' => $this->user_id,
            'lo.birthday' => $this->birthday,
            'lo.type' => $this->type,
            'lo.date_issue' => $this->date_issue,
            'lo.status_olympic' => $this->status_olympic,
            'lo.grade_number' => $this->grade_number,
            'lo.grade_performs' => $this->grade_performs,
            'lo.is_allergy' => $this->is_allergy,
            'lo.is_success' => $this->is_success,
            'lo.mark_end' => $this->mark_end,
            'lo.mark_end_two' => $this->mark_end_two,
            'lo.mark_end_three' => $this->mark_end_three,
            'lo.mark_end_last' => $this->mark_end_last,
            'lo.status_last' => $this->status_last,
            'lo.is_voz' => $this->is_voz,
            'lo.is_need_conditions' => $this->is_need_conditions,
            'lo.created_at' => $this->created_at,
            'lo.updated_at' => $this->updated_at,
            'lo.date_arrival' => $this->date_arrival,
            'lo.type_transport_arrival' => $this->type_transport_arrival,
            'lo.date_departure' => $this->date_departure,
            'lo.type_transport_departure' => $this->type_transport_departure,
            'gender' => $this->gender
        ]);

        if (!empty($this->personal)) {
            $query->innerJoin(UserPersonsLiterature::tableName() . ' upl', 'upl.user_id = lo.user_id');
            $query->andWhere(['upl.persons_literature_id' => $this->personal]);
        }

        $query->andFilterWhere(['like', 'lo.series', $this->series])
            ->andFilterWhere(['like', 'lo.number', $this->number])
            ->andFilterWhere(['like', 'lo.authority', $this->authority])
            ->andFilterWhere(['like', 'lo.region', $this->region])
            ->andFilterWhere(['like', 'lo.zone', $this->zone])
            ->andFilterWhere(['like', 'lo.city', $this->city])
            ->andFilterWhere(['like', 'lo.full_name', $this->full_name])
            ->andFilterWhere(['like', 'lo.short_name', $this->short_name])
            ->andFilterWhere(['like', 'lo.mark_olympic', $this->mark_olympic])
            ->andFilterWhere(['like', 'lo.grade_letter', $this->grade_letter])
            ->andFilterWhere(['like', 'lo.fio_teacher', $this->fio_teacher])
            ->andFilterWhere(['like', 'lo.place_work', $this->place_work])
            ->andFilterWhere(['like', 'lo.post', $this->post])
            ->andFilterWhere(['like', 'lo.academic_degree', $this->academic_degree])
            ->andFilterWhere(['like', 'lo.size', $this->size])
            ->andFilterWhere(['like', 'lo.code', $this->code])
            ->andFilterWhere(['like', 'lo.code_two', $this->code_two])
            ->andFilterWhere(['like', 'lo.code_three', $this->code_three])
            ->andFilterWhere(['like', 'lo.note_allergy', $this->note_allergy])
            ->andFilterWhere(['like', 'lo.note_conditions', $this->note_conditions])
            ->andFilterWhere(['like', 'lo.note_special', $this->note_special])
            ->andFilterWhere(['like', 'lo.place_arrival', $this->place_arrival])
            ->andFilterWhere(['like', 'lo.number_arrival', $this->number_arrival])
            ->andFilterWhere(['like', 'lo.place_departure', $this->place_departure])
            ->andFilterWhere(['like', 'lo.number_departure', $this->number_departure])
            ->andFilterWhere(['like', 'lo.photo', $this->photo])
            ->andFilterWhere(['like', 'lo.agree_file', $this->agree_file])
            ->andFilterWhere(['like', 'phone', $this->phone])
            ->andFilterWhere(['like', 'email', $this->email])
            ->andFilterWhere(['like', 'last_name', $this->last_name])
            ->andFilterWhere(['like', 'first_name', $this->first_name])
            ->andFilterWhere(['like', 'patronymic', $this->patronymic])
            ->andFilterWhere(['like', 'lo.hash', $this->hash]);

        return $query;
    }
}