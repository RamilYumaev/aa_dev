<?php


namespace modules\entrant\models;

use dictionary\models\DictDiscipline;
use modules\entrant\forms\AddressForm;
use modules\entrant\forms\UserDisciplineCseForm;
use modules\entrant\models\queries\UserCgQuery;
use modules\entrant\models\queries\UserDisciplineQuery;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "{{%discipline_user}}".
 *
 * @property integer $id
 * @property integer $user_id
 * @property integer $mark
 * @property integer $status_cse
 * @property integer $type
 * @property integer $discipline_id
 * @property string  $year
 * @property integer $discipline_select_id
 *
 **/

class UserDiscipline extends  ActiveRecord
{
    const CSE = 1;
    const VI = 2;
    const CT = 3;
    const CSE_VI = 4;
    const CT_VI = 5;

    public static function create(UserDisciplineCseForm $form) {
        $discipline =  new static();
        $discipline->data($form);
        return $discipline;
    }

    public function data(UserDisciplineCseForm $form) {
        $this->discipline_id = $form->discipline_id;
        $this->discipline_select_id = $form->discipline_select_id ?: $form->discipline_id;
        $this->year = $form->type == self::VI ? '' : $form->year;
        $this->mark = $form->type == self::VI ? null : $form->mark;
        $this->type = $form->type;
        $this->user_id = $form->user_id;
    }

    public function getDictDiscipline() {
       return  $this->hasOne(DictDiscipline::class, ['id' => 'discipline_id']);
    }

    public function getDictDisciplineSelect() {
        return  $this->hasOne(DictDiscipline::class, ['id' => 'discipline_select_id']);
    }

    public function getTypeList() {
        return [
            self::CSE => [
                'name' => 'Единый государственный экзамен', 'name_short' => "ЕГЭ",
            ],
            self::VI => [
            'name' => 'Вступительное испытание', 'name_short' => "ВИ",
            ],
            self::CT => [
                'name' => 'Централизованное тестирование', 'name_short' => "ЦТ",
            ],
            self::CSE_VI => [
                'name' => 'Единый государственный экзамен или вступительное испытание', 'name_short' => "ЕГЭ или ВИ",
            ],
            self::CT_VI => [
                'name' => 'Централизованное тестирование или вступительное испытание', 'name_short' => "ЦТ  или ВИ",
            ]
        ];
    }

    public function getTypeListKey($nameKey) {
       return array_combine(array_keys($this->getTypeList()), array_column($this->getTypeList(), $nameKey));
    }

    public function getNameShortType() {
        return $this->getTypeList()[$this->type]['name_short'];
    }

    public static function tableName()
    {
        return "{{%discipline_user}}";
    }

    public function attributeLabels()
    {
        return ['mark' => 'Балл',
            'year' => 'Год сдачи',
            'type' => 'Тип',
            'discipline_id' => 'Предмет'];
    }

    public static function find(): UserDisciplineQuery
    {
        return new UserDisciplineQuery(static::class);
    }


}