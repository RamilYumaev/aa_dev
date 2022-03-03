<?php

namespace modules\literature\models;

use common\auth\models\User;
use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "literature_olympic".
 *
 * @property int $id
 * @property int $user_id
 * @property string $birthday
 * @property int $type
 * @property string $series
 * @property string $number
 * @property string $date_issue
 * @property string $authority
 * @property string $region
 * @property string $zone
 * @property string $city
 * @property string $full_name
 * @property string $short_name
 * @property int $status_olympic
 * @property string $mark_olympic
 * @property int $grade_number
 * @property string|null $grade_letter
 * @property int $grade_performs
 * @property string $fio_teacher
 * @property string $place_work
 * @property string $post
 * @property string|null $academic_degree
 * @property string $size
 * @property int|null $is_allergy
 * @property string|null $note_allergy
 * @property int|null $is_voz
 * @property int|null $is_need_conditions
 * @property string|null $note_conditions
 * @property string|null $note_special
 * @property int $created_at
 * @property int $updated_at
 * @property string|null $date_arrival
 * @property int|null $type_transport_arrival
 * @property string|null $place_arrival
 * @property string|null $number_arrival
 * @property string|null $date_departure
 * @property int|null $type_transport_departure
 * @property string|null $place_departure
 * @property string|null $number_departure
 *
 * @property User $user
 */
class LiteratureOlympic extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'literature_olympic';
    }

    public function behaviors()
    {
        return [TimestampBehavior::class];
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id', 'birthday', 'type', 'series', 'number', 'date_issue', 'authority', 'region', 'zone', 'city', 'full_name', 'short_name', 'status_olympic', 'mark_olympic', 'grade_number', 'grade_performs', 'fio_teacher', 'place_work', 'post', 'size'], 'required'],
            [['user_id', 'type', 'status_olympic', 'grade_number', 'grade_performs', 'is_allergy', 'is_voz', 'is_need_conditions', 'type_transport_arrival', 'type_transport_departure'], 'integer'],
            [['birthday', 'date_arrival', 'date_departure'], 'safe'],
            [['note_allergy', 'note_conditions', 'note_special'], 'string'],
            [['series', 'number', 'date_issue', 'authority', 'region', 'zone', 'city', 'full_name', 'short_name', 'fio_teacher', 'place_work', 'post', 'academic_degree', 'size', 'place_arrival', 'place_departure'], 'string', 'max' => 255],
            [['mark_olympic'], 'string', 'max' => 5],
            [['grade_letter'], 'string', 'max' => 1],
            [['number_arrival', 'number_departure'], 'string', 'max' => 10],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'User ID',
            'birthday' => 'Birthday',
            'type' => 'Type',
            'series' => 'Series',
            'number' => 'Number',
            'date_issue' => 'Date Issue',
            'authority' => 'Authority',
            'region' => 'Region',
            'zone' => 'Zone',
            'city' => 'City',
            'full_name' => 'Full Name',
            'short_name' => 'Short Name',
            'status_olympic' => 'Status Olympic',
            'mark_olympic' => 'Mark Olympic',
            'grade_number' => 'Grade Number',
            'grade_letter' => 'Grade Letter',
            'grade_performs' => 'Grade Performs',
            'fio_teacher' => 'Fio Teacher',
            'place_work' => 'Place Work',
            'post' => 'Post',
            'academic_degree' => 'Academic Degree',
            'size' => 'Size',
            'is_allergy' => 'Is Allergy',
            'note_allergy' => 'Note Allergy',
            'is_voz' => 'Is Voz',
            'is_need_conditions' => 'Is Need Conditions',
            'note_conditions' => 'Note Conditions',
            'note_special' => 'Note Special',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'date_arrival' => 'Date Arrival',
            'type_transport_arrival' => 'Type Transport Arrival',
            'place_arrival' => 'Place Arrival',
            'number_arrival' => 'Number Arrival',
            'date_departure' => 'Date Departure',
            'type_transport_departure' => 'Type Transport Departure',
            'place_departure' => 'Place Departure',
            'number_departure' => 'Number Departure',
        ];
    }

    /**
     * Gets query for [[User]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }
}
