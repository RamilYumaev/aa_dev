<?php

namespace modules\transfer\models;

use yii\db\ActiveRecord;

/**
 * @property int $id
 * @property array|string $finances
 * @property array|string $citizenship
 * @property array|string $semesters
 * @property string $date_start
 * @property string $date_end
 */
class TransferSetting extends ActiveRecord
{
    public static function tableName(): string
    {
        return 'transfer_setting';
    }

    public function rules(): array
    {
        return [
            [['finances', 'citizenship', 'semesters'], 'safe'],
            [['date_start', 'date_end'], 'datetime'],
        ];
    }

    public function attributeLabels(): array
    {
        return [
            'id' => 'ID',
            'finances' => 'Finances',
            'citizenship' => 'Citizenship',
            'semesters' => 'Semesters',
            'date_start' => 'Date Start',
            'date_end' => 'Date End',
        ];
    }
}
