<?php

namespace modules\dictionary\models;


use common\moderation\behaviors\ModerationBehavior;
use common\moderation\interfaces\YiiActiveRecordAndModeration;
use modules\dictionary\forms\DictCategoryForm;
use modules\dictionary\forms\DictTestingEntrantForm;
use modules\management\repositories\ScheduleRepository;
use yii\db\ActiveRecord;

/**
 * Class  DictTestingEntrant
 * @package modules\entrant\models
 * @property string $name
 * @property string $description
 * @property string $result
 * @property boolean $is_auto
 * @property integer $priority
 * @property  integer $id
 *
 */
class DictTestingEntrant extends ActiveRecord
{

    public static function tableName()
    {
        return "{{%dict_testing_entrant}}";
    }

    public static function create(DictTestingEntrantForm $form)
    {
        $dictCategory = new static();
        $dictCategory->data($form);
        return $dictCategory;
    }

    public function data(DictTestingEntrantForm $form)
    {
        $this->name = $form->name;
        $this->description = $form->description;
        $this->result = $form->result;
        $this->priority = $form->priority;
        $this->is_auto = $form->is_auto;
    }

    public function attributeLabels()
    {
        return [
            'id' => 'id',
            'name' => 'Наименование',
            'description' => 'Описание задачи',
            'is_auto' => 'Добавить задачу по умолчнанию',
            'result' => 'Результат задачи',
            'priority' => 'Приоритет',
        ];
    }
}