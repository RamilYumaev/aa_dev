<?php


namespace modules\dictionary\models;

use dictionary\models\DictCompetitiveGroup;
use dictionary\models\DictSpeciality;
use dictionary\models\Faculty;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "{{%register_competition_list}}".
 *
 * @property integer $id
 * @property integer $ais_cg_id
 * @property integer $se_id
 * @property integer $status
 * @property integer $type_update
 * @property integer $number_update
 * @property integer $speciality_id;
 * @property integer $faculty_id;
 * @property string $date
 * @property string $time
 * @property string $error_message
 **/

class RegisterCompetitionList extends ActiveRecord
{
    const TYPE_AUTO = 1;
    const TYPE_HANDLE = 2;

    const STATUS_QUEUE = 0;
    const STATUS_SEND = 1;
    const STATUS_SUCCESS = 2;
    const STATUS_ERROR = 3;
    const STATUS_NOT = 4;

    public function data($aisCgId,  $typeUpdate, $numberUpdate, $specialityId, $facultyId, $seId)
    {
        $this->ais_cg_id = $aisCgId;
        $this->type_update = $typeUpdate;
        $this->speciality_id = $specialityId;
        $this->faculty_id = $facultyId;
        $this->se_id = $seId;
        $this->number_update = $numberUpdate;
        $this->date = date("Y-m-d");
        $this->time = date("H:i:s");
    }

    public function setStatus($status) {
        $this->status = $status;
    }

    public function listType() {
        return [self::TYPE_AUTO => 'auto', self::TYPE_HANDLE => 'handle'];
    }

    public function getTypeName() {
        return $this->listType()[$this->type_update];
    }

    public function listStatus() {
        return [
            self::STATUS_QUEUE =>  'отправлено  в очередь',
            self::STATUS_SEND => 'отправлено в АИС ВУЗ',
            self::STATUS_SUCCESS => 'успешно обновлен',
            self::STATUS_ERROR => 'ошибка',
            self::STATUS_NOT => 'нет списка',
        ];
    }

    public function getStatusName()
    {
        return $this->listStatus()[$this->status];
    }

    public function isStatusError() {
        return $this->status == self::STATUS_ERROR;
    }

    public function isStatusSend() {
        return $this->status == self::STATUS_SEND;
    }

    public function setErrorMessage($message) {
        $this->error_message = $message;
    }

    public static function tableName()
    {
        return "{{%register_competition_list}}";
    }

    public function getSettingCompetitionList()
    {
        return $this->hasOne(SettingCompetitionList::class,['se_id'=> 'se_id']);
    }

    public function getSettingEntrant()
    {
        return $this->hasOne(SettingEntrant::class,['id'=> 'se_id']);
    }

    public function getCompetitionList()
    {
        return $this->hasMany(CompetitionList::class,['rcl_id'=> 'id']);
    }

    public function getCompetitionListNo()
    {
        return $this->getCompetitionList()->andWhere(['type'=> 'list']);
    }

    public function getCompetitionListBvi()
    {
        return $this->getCompetitionList()->andWhere(['type'=> 'list_bvi']);
    }

    public function getCg()
    {
        return $this->hasOne(DictCompetitiveGroup::class, ['ais_id' => 'ais_cg_id'])->currentAutoYear();
    }

    public function getCgFacultyAndSpeciality()
    {
        return $this->hasOne(DictCompetitiveGroup::class, ['speciality_id' => 'speciality_id', 'faculty_id' => 'faculty_id'])->andWhere(['financing_type_id'=>2])->currentAutoYear();
    }

    public function getFaculty()
    {
        return $this->hasOne(Faculty::class, ['id' => 'faculty_id']);
    }

    public function getSpeciality()
    {
        return $this->hasOne(DictSpeciality::class, ['id' => 'speciality_id']);
    }

    public function attributeLabels()
    {
        return [
            'ais_cg_id' => "АИС КГ ИД",
            'status' => "Статус",
            'type_update' => "Тип обновления",
            'number_update' => "Номер обновления",
            'date' => "Дата обновления",
            'time' => "Время обновления",
            'error_message' => 'Сообщение об ошибке',
            'se_id' => "ИД настройки приема"
        ];
    }
}