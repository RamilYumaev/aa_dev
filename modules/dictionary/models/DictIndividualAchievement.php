<?php

namespace modules\dictionary\models;

use modules\dictionary\forms\DictIndividualAchievementForm;
use modules\dictionary\helpers\DictDefaultHelper;
use modules\entrant\models\UserCg;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "{{%dict_individual_achievement}}".
 *
 * @property integer $id
 * @property string $name
 * @property string $name_short
 * @property integer $mark
 * @property integer $category_id
 * @property string $year
 *
 **/
class DictIndividualAchievement extends ActiveRecord
{

    public static function tableName()
    {
        return "{{%dict_individual_achievement}}";
    }

    public static function create(DictIndividualAchievementForm $form)
    {
        $dictIndividualAchievement = new static();
        $dictIndividualAchievement->data($form);
        return $dictIndividualAchievement;
    }

    public function data(DictIndividualAchievementForm $form)
    {
        $this->name = $form->name;
        $this->category_id = $form->category_id;
        $this->mark = $form->mark;
        $this->year = $form->year;
        $this->name_short = $form->name_short;
    }

    public function getCategory()
    {
        return DictDefaultHelper::categoryDictIAName($this->category_id);
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Полное описание ИД',
            'name_short' => 'Краткое описание ИД',
            'mark' => 'Максимальный балл',
            'category_id' => 'Категория',
            'year' => 'Год',
            'competitiveGroupsList' => 'Конкурсные группы',
            'documentTypesList' => 'Виды документов',
        ];
    }


}