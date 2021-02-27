<?php


namespace modules\dictionary\models;

use common\auth\models\SettingEmail;
use dictionary\helpers\DictFacultyHelper;
use dictionary\models\DictClass;
use dictionary\models\Faculty;
use modules\dictionary\forms\VolunteeringForm;
use modules\dictionary\helpers\JobEntrantHelper;
use olympic\models\auth\Profiles;
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
 * @property string $number_edu
 * @property string $link_vk
 * @property string $note
 * @property array $desire_work
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
        $this->link_vk = $form->link_vk;
        $this->desire_work = json_encode($form->desire_work);
        $this->number_edu = $form->number_edu;
    }

    public static function tableName()
    {
        return "{{%volunteering}}";
    }

    public function getEntrantJob() {
        return $this->hasOne(JobEntrant::class, ['id' => 'job_entrant_id']);
    }

    public function getSettingEmail() {
        return $this->hasOne(SettingEmail::class, ['id' => 'email_id']);
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

    public function attributeLabels()
    {
        return [
            'job_entrant_id'=> "EntrantJob ID",
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
        ];
    }
}