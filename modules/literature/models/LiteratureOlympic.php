<?php

namespace modules\literature\models;

use common\auth\models\User;
use dictionary\models\Region;
use modules\usecase\ImageUploadBehaviorYiiPhp;
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
 * @property string|null $hash
 * @property string|null $agree_file
 * @property string|null $photo
 * @property string|null $code
 * @property integer|null $mark_end
 * @property string|null $code_two
 * @property integer|null $mark_end_two
 * @property string|null $code_three
 * @property integer|null $mark_end_three
 * @property integer|null $mark_end_last
 * @property integer|null $status_last
 * @property boolean $is_success
 *
 * @property User $user
 */
class LiteratureOlympic extends \yii\db\ActiveRecord
{
    const PERSON_DATA_CREATE = 'peron_data_create';
    const PERSON_DATA = 'peron_data';
    const SCHOOL_DATA = 'school_data';
    const ADDITIONAL_DATA = 'additional_data';
    const ROUTE_DATA = 'route_data';
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'literature_olympic';
    }

    public function behaviors()
    {
        return [
            TimestampBehavior::class,
            [
                'class' => ImageUploadBehaviorYiiPhp::class,
                'attribute' => 'agree_file',
                'filePath' => '@modules/literature/files/olympic/[[attribute_user_id]]/[[attribute_agree_file]]',
            ],
            [
                'class' => ImageUploadBehaviorYiiPhp::class,
                'attribute' => 'photo',
                'filePath' => '@modules/literature/files/olympic/[[attribute_user_id]]/[[attribute_photo]]',
            ],
        ];
    }

    public function scenarios()
    {
        return [
                self::PERSON_DATA => ['birthday', 'type', 'series', 'number', 'date_issue', 'authority', 'region', 'zone', 'city', 'agree_file', 'photo'],
                self::PERSON_DATA_CREATE => ['birthday', 'type', 'series', 'number', 'date_issue', 'authority', 'region', 'zone', 'city', 'agree_file', 'photo'],
                self::SCHOOL_DATA => ['full_name', 'short_name', 'status_olympic', 'mark_olympic', 'grade_number', 'grade_letter', 'grade_performs', 'fio_teacher', 'place_work', 'post', 'academic_degree'],
                self::ADDITIONAL_DATA => [ 'size', 'agree_file',  'is_allergy', 'is_voz', 'is_need_conditions', 'note_allergy', 'note_conditions', 'note_special', ],
                self::ROUTE_DATA => ['type_transport_arrival', 'type_transport_departure', 'date_arrival', 'date_departure', 'place_arrival', 'place_departure', 'number_arrival', 'number_departure'],
                self::SCENARIO_DEFAULT =>  ['birthday', 'type', 'series', 'number', 'date_issue', 'authority', 'region', 'zone', 'city',
                    'full_name', 'short_name', 'status_olympic', 'mark_olympic', 'grade_number', 'grade_letter', 'grade_performs', 'fio_teacher', 'place_work', 'post', 'academic_degree',
                    'size', 'agree_file',  'is_allergy', 'is_voz', 'is_need_conditions', 'note_allergy', 'note_conditions', 'note_special',
                    'type_transport_arrival', 'type_transport_departure', 'date_arrival', 'date_departure', 'place_arrival', 'place_departure', 'number_arrival', 'number_departure', 'code', 'mark_end',
                    'code_two', 'mark_end_two', 'code_three', 'mark_end_three', 'mark_end_last', 'status_last'
                    ],
            ];
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['birthday', 'type', 'series', 'number', 'date_issue', 'authority', 'region', 'zone', 'city', 'full_name', 'short_name', 'status_olympic', 'mark_olympic', 'grade_number', 'grade_performs', 'fio_teacher', 'place_work', 'post', 'size'], 'required'],
            [['user_id', 'type', 'status_olympic', 'grade_number', 'grade_performs', 'is_allergy', 'status_last', 'is_voz', 'is_need_conditions', 'type_transport_arrival', 'type_transport_departure'], 'integer'],
            [['birthday', 'date_arrival', 'date_departure'], 'safe'],
            [['date_arrival', 'date_departure'],'date', 'format' => 'yyyy-M-d H:m:s', "message"=> 'Неверный формат даты, пример, 2022-03-24 14:00:00'],
            [['agree_file', 'photo'], 'required', 'on' => self::PERSON_DATA_CREATE],
            ['note_allergy', 'required', 'when' => function($model) {return $model->is_allergy == 1;},
                'whenClient' => 'function (attribute, value) { return $("#literatureolympic-is_allergy").val() === 1}'],
            ['note_conditions', 'required', 'when' => function($model) {return $model->is_need_conditions == 1;},
                'whenClient' => 'function (attribute, value) { return $("#literatureolympic-is_need_conditions").val() === 1}'],
            [['note_allergy', 'note_conditions', 'note_special'], 'string'],
            [['series', 'number', 'date_issue', 'authority', 'region', 'zone', 'city', 'full_name', 'short_name', 'fio_teacher', 'place_work', 'post', 'academic_degree', 'size', 'place_arrival', 'place_departure'], 'string', 'max' => 255],
            [['mark_olympic'], 'string', 'max' => 5],
            [['mark_end', 'mark_end_two', 'mark_end_three', 'mark_end_last'], 'integer', 'max' => 100],
            [['code', 'code_two', 'code_three'], 'string', 'max' => 50],
            [['grade_letter'], 'string', 'max' => 2],
            [['number_arrival', 'number_departure'], 'string', 'max' => 10],
            ['photo', 'image',
                'extensions' => 'jpg, png, jpeg',
                'maxSize' => 1024 * 1024 * 10, 'on' => [self::PERSON_DATA_CREATE, self::PERSON_DATA]],
            ['agree_file', 'file',
                'extensions' => 'pdf',
                'maxSize' => 1024 * 1024 * 10, 'on' => [self::PERSON_DATA_CREATE, self::PERSON_DATA]],
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
            'birthday' => 'Дата рождения',
            'type' => 'Документ, удостоверяющий личность',
            'typeName' => 'Документ, удостоверяющий личность',
            'series' => 'Серия',
            'number' => 'Номер',
            'date_issue' => 'Дата выдачи',
            'authority' => 'Кем выдан?',
            'region' => 'Регион проживания',
            'regionName' => 'Регион проживания',
            'zone' => 'Район/область',
            'city' => 'Город/населенный пункт проживания',
            'full_name' => 'Полное наименование общеобразовательной организации (по уставу)',
            'short_name' => 'Сокращенное наименование общеобразовательной организации (по уставу)',
            'status_olympic' => 'Статус участника олимпиады',
            'statusName' => 'Статус участника олимпиады',
            'mark_olympic' => 'Кол-во набранных баллов на региональном этапе в 2021/2022 учебном году',
            'grade_number' => 'Класс, в котором обучается участник',
            'grade_letter' => 'Литер',
            'gradeLetterName' => 'Литер',
            'grade_performs' => 'Класс, за который выступает участник',
            'fio_teacher' => 'ФИО наставника, подготовившего участника олимпиады',
            'place_work' => 'Место работы наставника',
            'post' => 'Должность наставника',
            'academic_degree' => 'Ученая степень',
            'academicName' => 'Ученая степень',
            'size' => 'Размер футболки',
            'is_allergy' => 'Есть ли аллергия на продукты питания и/или медицинские препараты?',
            'note_allergy' => "Укажите, на какие именно продукты питания и/или медицинские препараты есть аллергия",
            'is_voz' => 'Относится ли участник к категории детей-инвалидов, инвалидов, детей с ОВЗ?',
            'is_need_conditions' => 'Нуждается ли участник в специальных условиях при организации олимпиад?',
            'note_conditions' => 'Укажите, какие специальные условия необходимо создать при организации олимпиады?',
            'note_special' => 'Особые сведения (непереносимость медицинских препаратов, хронический заболевания, о которых необходимо знать организаторам)',
            'created_at' => 'Дата создания записи',
            'updated_at' => 'Дата обновления записи',
            'date_arrival' => 'Дата и время прилета/приезда',
            'type_transport_arrival' => 'Вид транспорта',
            'typeTransportArrivalName' => 'Вид транспорта',
            'place_arrival' => 'Место прибытия (аэропорт/ ж/д вокзал, автовокзал и т.д.)',
            'number_arrival' => 'Номер рейса самолета или номер поезда и вагона',
            'date_departure' => 'Дата и время вылета/выезда',
            'type_transport_departure' => 'Вид транспорта',
            'typeTransportDepartureName' => 'Вид транспорта',
            'place_departure' => 'Место отбытия (аэропорт/ ж/д вокзал, автовокзал и т.д.)',
            'number_departure' => 'Номер рейса самолета или номер поезда и вагона',
            'agree_file' => 'Согласие на обработку персональных данных',
            'photo' => 'Фотография 3x4 (необходимо загрузить)',
            'is_success'=> "Подтвержден?",
            'code' => 'Шифр 1',
            'mark_end' => "Оценка 1",
            'code_two' => 'Шифр 2',
            'mark_end_two' => "Оценка 2",
            'code_three' => 'Шифр 3',
            'mark_end_three' => "Оценка 3",
            'mark_end_last' => "Итоговая оценка",
            'status_last' => "Статус участника"
        ];
    }

    public function getUserStatuses(){
        return [
            1 => 'победитель',
            2 => 'призер',
            3 => 'участник',
        ];
    }

    public function getStatusUserName() {
        return key_exists($this->status_last, $this->getUserStatuses())
            ? $this->getUserStatuses()[$this->status_last] : "";
    }

    public function getOlympicStatuses(){
        return [
            1 => 'прошел по баллам в 2022 году',
            2 => 'по квоте субъекта РФ в 2022 году',
            3 => 'прошел по баллам в 2021 году',
            4 => 'иное'
        ];
    }

    public function getGenderName() {
        return \olympic\helpers\auth\ProfileHelper::genderName($this->user->profiles->gender);
    }

    public function getSuccessName() {
        return $this->is_success ?"Да":"Нет";
    }

    public function getStatusName() {
        return key_exists($this->status_olympic, $this->getOlympicStatuses())
            ? $this->getOlympicStatuses()[$this->status_olympic] : $this->status_olympic;
    }

    public function  getAcademicDegreeList(){
        return [
            1 => 'нет степени',
            2 => 'кандидат наук',
            3 => 'доктор наук',
        ];
    }

    public function getAcademicName() {
        return key_exists($this->academic_degree, $this->getAcademicDegreeList()) ? $this->getAcademicDegreeList()[$this->academic_degree] : "";
    }

    public function getGrades(){
        return [
            9 => 9,
            10 => 10,
            11 => 11,
        ];
    }

    public function  getDocuments() {
        return [1 => 'паспорт',
            2 => 'свидетельство о рождении'];
    }

    public function getTypeName() {
        return key_exists($this->type, $this->getDocuments()) ? $this->getDocuments()[$this->type] : "";
    }

    public function getTransports() {
        return [
            1 => 'автобус',
            2 => 'поезд',
            3 => 'самолет',
            4 => 'автомобиль'
        ];
    }

    public function getRegionName() {
        return $this->regionDb ? $this->regionDb->name : "";
    }

    public function getTypeTransportArrivalName() {
        return key_exists($this->type_transport_arrival, $this->getTransports()) ? $this->getTransports()[$this->type_transport_arrival] : "";
    }

    public function getTypeTransportDepartureName() {
        return key_exists($this->type_transport_departure, $this->getTransports()) ? $this->getTransports()[$this->type_transport_departure] : "";
    }

    public function getSizes() {
        return [
            'S' => 'S',
            'M' => 'M',
            'L' => 'L',
            'XL' => 'XL',
            'XXL' => "XXL",
            'XXXL' => 'XXXL',
            'другое' => 'другое'
        ];
    }

    public function getLetters() {
        $array = array(
            "-",

            'А', 'Б', 'В', 'Г', 'Д', 'Е', 'Ё', 'Ж', 'З', 'И', 'Й', 'К', 'Л', 'М', 'Н', 'О', 'П', 'Р',

            'С', 'Т', 'У', 'Ф', 'Х', 'Ц', 'Ч', 'Ш', 'Щ', 'Ъ', 'Ы', 'Ь', 'Э', 'Ю', 'Я'

        );
        return $array;
    }

    public function getGradeLetterName() {
        return key_exists($this->grade_letter, $this->getLetters()) ? $this->getLetters()[$this->grade_letter] : "";
    }

    public function getPersonals() {
        if($this->getUserPersonsLiterature()->exists()) {
            $result = "";
            /** @var UserPersonsLiterature $userPerson */
            foreach ($this->getUserPersonsLiterature()->all() as $userPerson) {
                $result .= $userPerson->personsLiterature->getDataFull()."<br/>";
            }
            return $result;
        }
        return "Нет данных";
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

    /**
     * Gets query for [[serPersonsLiterature]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUserPersonsLiterature()
    {
        return $this->hasMany(UserPersonsLiterature::class, ['user_id' => 'user_id']);
    }


    /**
     * Gets query for [[Region]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getRegionDb()
    {
        return $this->hasOne(Region::class, ['id' => 'region']);
    }
}
