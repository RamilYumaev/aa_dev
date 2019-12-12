<?php


namespace olympic\models;


use yii\db\ActiveRecord;

class SpecialTypeOlimpic extends ActiveRecord
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

    public function edit($olimpic_id, $special_type_id)
    {
        $this->olimpic_id = $olimpic_id;
        $this->special_type_id = $special_type_id;
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