<?php


namespace olympic\models;


class SpecialTypeOlimpic
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'special_type_olimpic';
    }

    public static function create($olimpic_id, $special_type_id)
    {
        $specialTypeOlimpic = new static();
        $specialTypeOlimpic->olimpic_id = $olimpic_id;
        $specialTypeOlimpic->special_type_id = $special_type_id;

        return $specialTypeOlimpic;
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'olimpic_id' => 'Olimpic ID',
            'special_type_id' => 'Специальный вид олимпиады',
        ];
    }

    public static function labels(): array
    {
        $specialTypeOlimpic = new static();
        return $specialTypeOlimpic->attributeLabels();
    }

}