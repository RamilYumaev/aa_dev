<?php


namespace olympic\models;
/**
 * This is the model .
 *
 * @property int $olimpic_list_id
 * @property string $olympic_speciality_id
 */

use yii\db\ActiveRecord;

class OlympicSpecialityOlimpicList extends ActiveRecord
{
    public static function create($olimpic_list_id, $olympic_speciality_id)
    {
        $olympicSpecialityList = new static();
        $olympicSpecialityList->olimpic_list_id = $olimpic_list_id;
        $olympicSpecialityList->olympic_speciality_id = $olympic_speciality_id;

        return $olympicSpecialityList;
    }

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'olympic_speciality_olimpic_list';
    }

    public static function allOlympicSpecialityByOlympicList($id) {
        return self::find()->select('olympic_speciality_id')->andWhere(['olimpic_list_id'=> $id])->column();
    }
}