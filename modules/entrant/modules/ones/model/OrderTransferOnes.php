<?php

namespace modules\entrant\modules\ones\model;
use yii\db\ActiveRecord;

/**
 * @property int $id
 * @property string $department
 * @property string $education_level
 * @property string $education_form
 * @property string $type_competitive
 *
 */
class OrderTransferOnes extends ActiveRecord
{
    public static function tableName(): string
    {
        return '{{%order_transfer_ones}}';
    }

    public function rules(): array
    {
        return [
            [['department', 'education_level','type_competitive', 'education_form'], 'required'],
            [['department'], 'string'],
            [['education_level', 'type_competitive', 'education_form'], 'safe'],
        ];
    }

    public function attributeLabels(): array
    {
        return [
            'education_level' => "Уровень образования",
            'department' => "Факультет/Филиал",
            'education_form' => "Форма обученмя",
            'type_competitive' => "Вид места",
        ];
    }

    public static function allEduLevels() {
        $data = CompetitiveGroupOnes::find()->select('education_level')->indexBy('education_level')->column();
        return $data;
    }

    public static function allTypes() {
        $data = CompetitiveGroupOnes::find()->select('type_competitive')->indexBy('type_competitive')->column();
        return $data;
    }

    public static function allForms() {
        $data = CompetitiveGroupOnes::find()->select('education_form')->indexBy('education_form')->column();
        return $data;
    }

    public static function allDepartments() {
        $data = CompetitiveGroupOnes::find()->select('department')->indexBy('department')->column();
        return $data;
    }
}
