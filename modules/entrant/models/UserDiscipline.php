<?php


namespace modules\entrant\models;

use common\moderation\behaviors\ModerationBehavior;
use common\moderation\interfaces\YiiActiveRecordAndModeration;
use dictionary\helpers\DictDisciplineHelper;
use dictionary\models\DictDiscipline;
use modules\entrant\behaviors\FileBehavior;
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

class UserDiscipline extends YiiActiveRecordAndModeration
{
    public function behaviors()
    {
        return ['moderation' => [
            'class'=> ModerationBehavior::class,
            'attributes'=>['mark','type', 'discipline_id', 'discipline_select_id', 'date', 'year'],
        ], FileBehavior::class];
    }

    const CSE = 1;
    const VI = 2;
    const CT = 3;
    const CSE_VI = 4;
    const CT_VI = 5;

    const STATUS_ACTIVE = 1;
    const STATUS_CANCEL_RR = 2;
    const STATUS_CANCEL_OUT_RR = 3;
    const STATUS_INVALID = 4;
    const STATUS_DEADLINE = 5;
    const STATUS_BELOW_MIN = 6;
    const STATUS_NOT_FOUND = 0;

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

    public function updateForAis($status, $year, $mark) {
        $this->year = $year;
        $this->mark = $mark;
        $this->status_cse = $status;
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

    public function getStatusList()
    {
        return [
            self::STATUS_ACTIVE => 'Действующий',
            self::STATUS_CANCEL_RR => 'Аннулирован с правом пересдачи',
            self::STATUS_CANCEL_OUT_RR => 'Аннулирован без права пересдачи',
            self::STATUS_INVALID => 'Недействительный результат по причине нарушения порядка проведения ГИА',
            self::STATUS_DEADLINE => 'Истек срок',
            self::STATUS_BELOW_MIN => 'Ниже минимума',
            self::STATUS_NOT_FOUND => 'Не проверено'
        ];
    }

    public function getStatusName()
    {
        return $this->type == self::VI ? '' : $this->getStatusList()[$this->status_cse];
    }

    public function getUserAis()
    {
        return $this->hasOne(UserAis::class, ['user_id' => 'user_id']);
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
            'status_cse' => 'Статус',
            'discipline_id' => 'Предмет',
            'discipline_select_id' => 'Предмет по выбору'];
    }

    public static function find(): UserDisciplineQuery
    {
        return new UserDisciplineQuery(static::class);
    }

    public function getFiles() {
        return $this->hasMany(File::class, ['record_id'=> 'id'])->where(['model'=> self::class]);
    }

    public function countFiles() {
        return $this->getFiles()->count();
    }

    public function titleModeration(): string
    {
        return "ЕГЭ, ЦТ, ВИ";
    }

    public function moderationAttributes($value): array
    {
        return [
            'mark' => $value,
            'year' => $value,
            'type' => $this->getTypeList()[$value]['name_short'],
            'discipline_id' => DictDisciplineHelper::disciplineName($value),
            'discipline_select_id' => DictDisciplineHelper::disciplineName($value)
        ];
    }
}