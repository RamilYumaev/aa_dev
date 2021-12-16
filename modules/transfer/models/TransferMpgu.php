<?php


namespace modules\transfer\models;

use common\moderation\behaviors\ModerationBehavior;
use common\moderation\interfaces\YiiActiveRecordAndModeration;
use dictionary\helpers\DictCompetitiveGroupHelper;
use dictionary\helpers\DictCountryHelper;
use dictionary\models\DictSpeciality;
use dictionary\models\DictSpecialization;
use dictionary\models\Faculty;
use modules\entrant\behaviors\FileBehavior;
use modules\entrant\forms\AddressForm;
use modules\entrant\helpers\AddressHelper;
use olympic\models\auth\Profiles;
use yii\db\ActiveRecord;
use yii\db\Exception;

/**
 * This is the model class for table "{{%transfer_mpgu}}".
 *
 * @property integer $id
 * @property integer $user_id
 * @property integer $current_status
 * @property string $data_mpgsu
 * @property integer $type
 * @property integer $year
 * @property string $number
**/

class TransferMpgu extends ActiveRecord
{
    const IN_MPGU = 1;
    const IN_INSIDE_MPGU = 2;
    const INSIDE_MPGU = 3;
    const FROM_EDU = 4;
    /* mphu */
    const STATUS_ACTIVE = 1;
    const STATUS_EXPELLED = 7;

    const STATUS_ACADEMIC_LEAVE = 2;
    const STATUS_REMOVE = 3;
    const STATUS_EXTENDED_DEADLINE = 4;
    const STATUS_SENT_WORD = 5;
    const STATUS_END_EDU = 9;
    const STATUS_VACATION = 10;
    const STATUS_EXPELLED_NO_RIGHT = 11;
    const STATUS_VACATION_WORK = 12;
    const STATUS_TRANSFER_EXAM = 13;

    const EDUCATION_FORM_FULL_TIME = 1;
    const EDUCATION_FORM_ABSENTIA = 2;
    const EDUCATION_FORM_PART_TIME = 3;
    const EDUCATION_FORM_EXTERNAL = 4;

    const ACTIVE = [self::STATUS_ACTIVE, self::STATUS_EXPELLED];

    public static function tableName()
    {
        return '{{%transfer_mpgu}}';
    }

    public function rules()
    {
        return [
            [['type', 'user_id'],'required'],
            [['number'],'string',  'min'=> 4,'max' => 10],
            [['year'],'integer',  'min'=> 2005,'max' => date('Y')-1],
            [['number','year'], 'required', 'when'=> function($model) {
                return $model->type != self::FROM_EDU;
            }, 'enableClientValidation' => false],
            ['type','in','range'=> [self::FROM_EDU, self::IN_INSIDE_MPGU, self::IN_MPGU, self::INSIDE_MPGU]]
        ];
    }

    public function listType() {
        return [
            self::IN_MPGU => 'Восстановление внутри МПГУ',
            self::IN_INSIDE_MPGU => 'Восстановление с переводом внутри МПГУ',
            self::INSIDE_MPGU => 'Перевод внутри МПГУ',
            self::FROM_EDU => 'Перевод из другой образовательной организации',
        ];
    }

    public function listTypeShort() {
        return [
            self::IN_MPGU => 'Восстановление',
            self::IN_INSIDE_MPGU => 'В. с переводом',
            self::INSIDE_MPGU => 'Перевод',
            self::FROM_EDU => 'Из другой',
        ];
    }

    public function listEduForm() {
        return [
            self::EDUCATION_FORM_FULL_TIME => 'Очно',
            self::EDUCATION_FORM_ABSENTIA => 'Заочно',
            self::EDUCATION_FORM_PART_TIME => 'Очно-заочно',
            self::EDUCATION_FORM_EXTERNAL => 'Экстернат'
        ];
    }

    public function listMessage() {
        return [
            self::STATUS_ACADEMIC_LEAVE => 'Вам недоступна процедура перевода/восстановления. Необходимо обратиться в дирекцию факультета/института',
            self::STATUS_VACATION => 'Вам недоступна процедура перевода/восстановления.',
            self::STATUS_EXTENDED_DEADLINE => 'Вам недоступна процедура перевода/восстановления.',
            self::STATUS_SENT_WORD => 'Вам недоступна процедура перевода/восстановления.',
            self::STATUS_EXPELLED_NO_RIGHT => 'Вам недоступна процедура перевода/восстановления.',
            self::STATUS_END_EDU => 'Вам недоступна процедура перевода/восстановления.',
            self::STATUS_REMOVE => 'Вам недоступна процедура перевода/восстановления.',
            self::STATUS_VACATION_WORK => 'Вам недоступна процедура перевода/восстановления.',
            self::STATUS_TRANSFER_EXAM => 'Вам недоступна процедура перевода/восстановления.',
        ];
    }

    public function isMpgu()  {
        return $this->type == TransferMpgu::IN_MPGU ||
            $this->type == TransferMpgu::IN_INSIDE_MPGU  ||
            $this->type == TransferMpgu::INSIDE_MPGU;
    }

    public function inMpgu()  {
        return $this->type == TransferMpgu::IN_MPGU;
    }

    public function insideMpgu()  {
        return $this->type == TransferMpgu::INSIDE_MPGU;
    }

    public function typeName() {
        return $this->listType()[$this->type];
    }

    public function getTypeNameShort() {
        return $this->listTypeShort()[$this->type];
    }

    public function getDataMpsu() {
        return $this->data_mpgsu ? json_decode($this->data_mpgsu,true) : null;
    }

    public function getJsonData() {
        $array = [];
        if($this->isMpgu()) {
            $data = $this->dataMpsu;
            if($data) {
                if($fac = Faculty::find()->facultyAis($data['faculty_id'])->one()) {
                    $array['faculty'] =  $fac->full_name;
                    $array['faculty_genitive'] = $fac->genitive_name;
                }else {
                    $array['faculty'] = '';
                }
                if($speciality = DictSpeciality::find()->andWhere(['ais_id'=> $data['specialty_id']])->one()) {
                    $array['speciality'] = $speciality->codeWithName;
                }else {
                    $array['speciality'] = '';
                }
                if($specialization = DictSpecialization::find()->andWhere(['ais_id'=> $data['specialization_id']])->one()) {
                    $array['specialization'] =  $specialization->name;
                }else {
                    $array['specialization'] =   '';
                }
                    $array['form'] =  $data['education_form_id'] ? self::listEduForm()[$data['education_form_id']] : '';
                    $array['course'] =$data['course'] ?? '';
                    $array['finance'] = $data['financing_type_id'] ?? '';
            }
        }
        return $array;
    }

    public function getProfile() {
        return $this->hasOne(Profiles::class,['user_id'=> 'user_id']);
    }

    public function getStatement() {
        return $this->hasOne(StatementTransfer::class,['user_id'=> 'user_id']);
    }

    public function isStatusMpsuCorrectType() {
        if($this->current_status  == self::STATUS_ACTIVE) {
            if(!in_array($this->type,[self::INSIDE_MPGU])){
                throw new Exception('Вы можете выбрать только "Перевод внутри МПГУ"');
            }
        }elseif($this->current_status  == self::STATUS_EXPELLED) {
            if(!in_array($this->type,[self::IN_INSIDE_MPGU, self::IN_MPGU])){
                throw new Exception('Вы можете выбрать только "Восстановление внутри МПГУ" или 
                "Восстановление с переводом внутри МПГУ');
            }
        }

    }

    public function attributeLabels()
    {
        return [
            'current_status' =>"Статус",
            'type' => "Условие перевода/восстановления",
            'user_id' => 'Студент',
            'number' => '№ студенческой зачетки',
            'year' => 'Год выдачи студенческой зачетки',
        ];
    }
}