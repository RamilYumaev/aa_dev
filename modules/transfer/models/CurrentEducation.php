<?php


namespace modules\transfer\models;

use common\moderation\behaviors\ModerationBehavior;
use common\moderation\interfaces\YiiActiveRecordAndModeration;
use dictionary\helpers\DictCountryHelper;
use modules\entrant\behaviors\FileBehavior;
use modules\entrant\forms\AddressForm;
use modules\entrant\helpers\AddressHelper;
use olympic\models\auth\Profiles;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "{{%transfer_mpgu}}".
 *
 * @property integer $id
 * @property integer $user_id
 * @property integer $current_status
 * @property integer $type
 * @property string $number
**/

class CurrentEducation extends ActiveRecord
{
    const EDU_ONE = 1;
    const EDU_MANY = 2;

    public static function tableName()
    {
        return '{{%current_education}}';
    }

    public function listEdu() {
        return [
            self::EDU_ONE => 'Первое высшее образование',
            self::EDU_MANY => 'Второе и последующее высшее образование',
        ];
    }

    public function eduName() {
        return $this->listEdu()[$this->type];
    }

    public function rules()
    {
        return [
            [['user_id',
                'school_id',
                'finance',
                'edu_count'.
                'speciality',
                'form',
                'course',], 'required'],
            [[
                'speciality',
            ], 'string', 'max'=> 255],
            [['user_id',
                'finance',
                'school_id',
                'edu_count',
                'form',
                'course',], 'integer'],
            ['current_analog','boolean']
        ];
    }

    public function getProfile() {
        return $this->hasOne(Profiles::class,['user_id'=> 'user_id']);
    }

    public function attributeLabels()
    {
        return [
            'user_id' =>  'ФИО',
            'finance' => 'Вид финансирования',
            'school_id' => 'Учебная организация',
            'speciality' => 'Направление подготовки',
            'specialization' => 'Наименование образовательной программы',
            'form' => 'Форма обучения',
            'edu_count'=> 'Обраование',
            'course' =>'Курс' ,
            'current_analog' => 'Перевод осуществляется на программу, курс и форму обучения, указанную в разделе “Действующее образование”'
        ];
    }
}