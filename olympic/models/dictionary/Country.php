<?php


namespace olympic\models\dictionary;


use yii\db\ActiveRecord;

class Country extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'dict_country';
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'name' => 'Название страны',
            'cis' => 'Cтрана к СНГ',
            'far_abroad' => 'Дальнее зарубежье',
        ];
    }
}