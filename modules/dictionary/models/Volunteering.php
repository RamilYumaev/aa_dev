<?php


namespace modules\dictionary\models;

use common\auth\models\SettingEmail;
use dictionary\helpers\DictCompetitiveGroupHelper;use dictionary\helpers\DictFacultyHelper;
use dictionary\models\DictClass;
use dictionary\models\Faculty;
use modules\dictionary\forms\VolunteeringForm;
use modules\dictionary\helpers\JobEntrantHelper;
use modules\dictionary\models\queries\VolunteeringQuery;
use modules\management\models\queries\ManagementUserQuery;
use olympic\helpers\auth\ProfileHelper;use olympic\models\auth\Profiles;
use testing\models\TestAttempt;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "{{%volunteering}}".
 *
 * @property integer $id
 * @property integer $job_entrant_id
 * @property integer $faculty_id
 * @property integer $form_edu
 * @property integer $course_edu
 * @property integer $clothes_size
 * @property integer $clothes_type
 * @property integer $finance_edu
 * @property boolean $experience
 * @property boolean $is_reception
 * @property string $number_edu
 * @property string $link_vk
 * @property string $note
 * @property array $desire_work
 * @property int $conditions_of_work
 *
 **/

class Volunteering extends ActiveRecord
{

    public static function create(VolunteeringForm $form)
    {
        $entrant = new static();
        $entrant->data($form);
        return $entrant;
    }

    public function data(VolunteeringForm $form)
    {
        $this->job_entrant_id = $form->job_entrant_id;
        $this->faculty_id = $form->faculty_id;
        $this->form_edu = $form->form_edu;
        $this->finance_edu = $form->finance_edu;
        $this->course_edu = $form->course_edu;
        $this->note = $form->note;
        $this->clothes_size = $form->clothes_size;
        $this->clothes_type = $form->clothes_type;
        $this->experience = $form->experience;
        $this->is_reception = $form->is_reception;
        $this->link_vk = $form->link_vk;
        $this->desire_work = json_encode($form->desire_work);
        $this->number_edu = $form->number_edu;
        $this->conditions_of_work = $form->conditions_of_work;
    }

    public static function tableName()
    {
        return "{{%volunteering}}";
    }

    public function getEntrantJob() {
        return $this->hasOne(JobEntrant::class, ['id' => 'job_entrant_id'])->joinWith('profileUser');
    }

    public function getSettingEmail() {
        return $this->hasOne(SettingEmail::class, ['id' => 'email_id']);
    }

    public function getAttempt() {
        return TestAttempt::find()->user($this->entrantJob->user_id)->test(195)->one();
    }

    public function getIsAttempt() {
       $is = $this->getAttempt();
       return $is->mark ? 'Прошел' : "Не прошел";
    }

    public function getAttemptMark() {
        $is = $this->getAttempt();
        return $is ? $is->mark : '';
    }


    public function getFaculty() {
        return $this->hasOne(Faculty::class, ['id' => 'faculty_id']);
    }

    public function getCourse() {
        return $this->hasOne(DictClass::class, ['id' => 'course_edu']);
    }

    public function listClothesSize() {
        return ['XS', 'S', 'M', 'L', 'XL', 'XXL', 'XXXL'];
    }

    public function listConditionsWork() {
        return ['Нет данных', 1 =>'Практика',  2 =>'Договор',  3 =>'Договор + практика'];
    }

    public function getConditionsWork() {
        return $this->listConditionsWork()[$this->conditions_of_work];
    }

    public function getClothesSize() {
        return $this->listClothesSize()[$this->clothes_size];
    }

     public function getClothesType() {
        return ProfileHelper::typeOfGender()[$this->clothes_type];
    }

    public function getFormEdu() {
        return DictCompetitiveGroupHelper::getEduForms()[$this->form_edu];
    }

    public function getFinanceEdu() {
        return DictCompetitiveGroupHelper::listFinances()[$this->finance_edu];
    }

    public function getDesireWork() {
        return   implode(', ', array_map(function ($role) {
            return JobEntrantHelper::listVolunteeringCategories()[$role];
        }, json_decode($this->desire_work)));
    }

    public function getIsReception() {
        return $this->is_reception ? 'Да' : "Нет";
    }

    public function attributeLabels()
    {
        return [
            'job_entrant_id'=> "Волонтер",
            'faculty_id' => "Факультет",
            'form_edu' => "Форма обучения",
            'course_edu' => "Курс",
            'number_edu' => "Номер зачетки/студенческого",
            'finance_edu' => "Основа обучения",
            'experience' => "Опыт работы в приемной кампании",
            'clothes_type' => "Тип одежды",
            'clothes_size' => "Размер одежды",
            'desire_work'  => "Желаемое направление работы",
            'link_vk' => "Ссылка на VK",
            'note' => "Коротко о Вас",
            'is_reception' => 'Участие в Приеме '.date("Y"),
            'conditions_of_work' => "Условия работы в ПК",
        ];
    }

    public static function find(): VolunteeringQuery
    {
        return new VolunteeringQuery(static::class);
    }
}