<?php
namespace modules\entrant\models;

use common\auth\models\User;
use common\moderation\behaviors\ModerationBehavior;
use common\moderation\interfaces\YiiActiveRecordAndModeration;
use modules\entrant\forms\AverageScopeSpoForm;

/**
 * This is the model class for table "{{%average_scope_spo}}".
 *
 * @property integer $id
 * @property integer $user_id
 * @property float $average
 * @property integer $number_of_threes
 * @property integer $number_of_fours
 * @property integer $number_of_fives
 **/

class AverageScopeSpo extends YiiActiveRecordAndModeration
{

    public static function create(AverageScopeSpoForm $form)
    {
        $model = new static();
        $model->data($form);
        return $model;
    }

    public function behaviors()
    {
        return [
            'moderation' => [
            'class'=> ModerationBehavior::class,
            'attributes'=>['number_of_threes', 'number_of_fours', 'number_of_fives', 'average'],
                ]
        ];
    }

    public static function tableName()
    {
        return '{{%average_scope_spo}}';
    }

    public function getUser() {
        return $this->hasOne(User::class, ['id'=> 'user_id']);
    }


    public function attributeLabels()
    {
        return  [
            'number_of_threes' => 'Количество "троек"',
            'number_of_fours' => 'Количество "четверок"',
            'number_of_fives' => 'Количество "пятерок"',
            'average' => "Средний балл"
        ];
    }

    public function titleModeration(): string
    {
        return  'Средний балл аттестата';
    }

    public function moderationAttributes($value): array
    {
        return  [
            'number_of_threes' => $value,
            'number_of_fours' => $value,
            'number_of_fives' => $value,
            'average' => $value,
        ];
    }

    public function data(AverageScopeSpoForm $form)
    {
        $this->number_of_threes = $form->number_of_threes;
        $this->number_of_fours = $form->number_of_fours;
        $this->number_of_fives = $form->number_of_fives;
        $this->user_id = $form->user_id;
        $this->average = $this->getAverageSum();
    }

    private function getAverageSum() {
        $result = ((5 * $this->number_of_fives) + (4 * $this->number_of_fours) + (3 * $this->number_of_threes)) /
        ($this->number_of_fives +  $this->number_of_fours +  $this->number_of_threes);
        return round($result, 5);
    }
}