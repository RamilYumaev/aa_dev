<?php
namespace modules\entrant\models;


use common\moderation\behaviors\ModerationBehavior;
use common\moderation\interfaces\YiiActiveRecordAndModeration;
use modules\entrant\forms\AnketaForm;
use yii\db\ActiveRecord;

/**
 * Class Anketa
 * @package modules\entrant\models
 * @property integer $id
 * @property integer $user_id
 * @property string $citizenship_id
 * @property integer $edu_finish_year
 * @property string $current_edu_level
 * @property string $category_id
 */
class Anketa extends ActiveRecord
{
    public static function tableName()
    {
        return "{{%anketa}}";
    }

//    public function behaviors()
//    {
////        return ['moderation' => [
////            'class'=> ModerationBehavior::class,
////            'attributes'=>['citizenship_id', 'edu_finish_year', 'current_edu_level', 'category_id']
////        ]];
////
////        return [[
////            'class'=>
////        ]
////        ];
//
//    }

    public static function create(AnketaForm $form)
    {
        $anketa = new static();
        $anketa->data($form);
        return $anketa;
    }

    public function data(AnketaForm $form)
    {
        $this->citizenship_id = $form->citizenship_id;
        $this->edu_finish_year = $form->edu_finish_year;
        $this->current_edu_level = $form->current_edu_level;
        $this->category_id = $form->category_id;
        $this->user_id = $form->user_id;

    }

//    public function titleModeration(): string
//    {
//        return "Анкета";
//    }

    public function attributeLabels()
    {
        return [
            'citizenship_id' => 'Какое у Вас гражданство?',
            'edu_finish_year' => 'В каком году Вы окончили последнюю образовательную организацию?',
            'current_edu_level' => 'Какой Ваш текущий уровень образования?',
            'category_id' => 'К какой категории граждан Вы относитесь?',
        ];
    }

//    public function moderationAttributes($value): array
//    {
//        return [
//            'citizenship_id' => $value,
//            'edu_finish_year' => $value,
//            'current_edu_level'=> $value,
//            'category_id'=> $value,
//        ];
//    }
}