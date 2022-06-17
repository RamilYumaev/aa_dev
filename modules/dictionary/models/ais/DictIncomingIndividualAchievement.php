<?php

namespace modules\dictionary\models\ais;

use Yii;

/**
 * This is the model class for table "2022_dict_incoming_individual_achievement".
 *
 * @property int $id ID
 * @property string $name Полное описание ИД
 * @property string $name_short Краткое описание ИД
 * @property int $mark Максимальный балл
 * @property int $category_id Категория
 * @property int $campaign_id Приёмная кампания
 */
class DictIncomingIndividualAchievement extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '2022_dict_incoming_individual_achievement';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'name_short', 'mark', 'category_id', 'campaign_id'], 'required'],
            [['mark', 'category_id', 'campaign_id'], 'integer'],
            [['name'], 'string', 'max' => 500],
            [['name_short'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'name_short' => 'Name Short',
            'mark' => 'Mark',
            'category_id' => 'Category ID',
            'campaign_id' => 'Campaign ID',
        ];
    }
}
