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
 * This is the model class for table "{{%current_education_info}}".
 *
 * @property integer $id
 * @property integer $user_id
 * @property integer $current_status
 * @property integer $type
 * @property string $number
**/

class CurrentEducationInfo extends ActiveRecord
{

    public static function tableName()
    {
        return '{{%current_education_info}}';
    }

    public function rules()
    {
        return [
        [['user_id',
            'year',
            'faculty',
            'finance',
            'specialization',
            'form',
            'course',], 'required'],
            [['faculty',
                'specialization',
            ], 'string', 'max'=> 255],
            [['user_id',
                'finance',
                'form',
                'course',], 'integer'],
            [['year',], 'string', 'max'=> 4, 'min' => 4]
        ];
    }

    public function attributeLabels()
    {
        return [
            'user_id' =>  'ФИО',
            'year' => 'Год поступления',
            'faculty' => 'Наименование института/факультета',
            'finance' => 'Вид финансирования',
            'specialization' => 'Наименование образовательной программы',
            'form' => 'Форма обучения',
            'course' =>'Курс' ,
        ];
    }

}