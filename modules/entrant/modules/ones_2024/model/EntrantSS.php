<?php

namespace modules\entrant\modules\ones_2024\model;
use yii\db\ActiveRecord;

/**
 * @property int $id
 * @property string $quid
 * @property string $fio
 * @property string $snils
 * @property string $id_ss
 * @property string $sex
 * @property string $nationality
 * @property string $type_doc
 * @property string $type
 * @property string $series
 * @property string $number
 * @property string $date_of_issue
 * @property string $authority
 * @property string $division_code
 * @property string $date_of_birth
 * @property string $place_of_birth
 * @property string $email
 * @property string $phone
 * @property boolean $is_hostel
 */

class EntrantSS extends ActiveRecord
{
    public $check;

    public static function tableName(): string
    {
        return '{{%entrant_2024_ss}}';
    }

    public function rules(): array
    {
        return [
            [[
            'quid',
            "fio",
            "snils",
            "id_ss",
            "sex",
            'nationality',
            'type_doc',
            'series',
            'number',
            'date_of_issue',
            'authority',
            'division_code',
            'date_of_birth',
            'place_of_birth',
            'email',
            'phone',
            'is_hostel'], 'safe',
            ],
        ];
    }

    public function attributeLabels(): array
    {
        return [
            'id' => 'id',
            'quid' => 'quid',
            "fio" => "ФИО",
            "snils" => "CНИЛС",
            "id_ss" => 'ID_external',
            "sex" => 'Пол',
            'nationality' => "Гражданство",
            'type_doc' => "Дул",
            'series' => 'Серия',
            'number' => "Номер",
            'date_of_issue' => "Дата выдачи",
            'authority' => "Кем выдан",
            'division_code' => "Код подразделения",
            'date_of_birth' => "Дата рождения",
            'place_of_birth' => "Место рождения",
            'email' => "Email",
            'phone' => "Телефон",
            'is_hostel' => "Нуждается в общежитии",
        ];
    }

    public function getEntrantApps()
    {
        return $this->hasMany(EntrantCgAppSS::class, ['quid_profile' => 'quid']);
    }

    public function getCg()
    {
        return $this->hasOne(CgSS::class, ['quid'=>'quid_cg_competitive'])
            ->via('entrantApps');
    }
}
