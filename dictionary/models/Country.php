<?php


namespace dictionary\models;


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

    public function rules()
    {
        return [
            ['name', 'required'],
            [['cis', 'far_abroad'], 'boolean'],
        ];
    }
}