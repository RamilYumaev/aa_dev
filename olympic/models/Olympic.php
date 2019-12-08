<?php


namespace olympic\models;

use dictionary\models\queries\DictClassQuery;
use olympic\forms\OlympicCreateForm;
use olympic\forms\OlympicEditForm;
use olympic\models\queries\OlimpicQuery;

class Olympic extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    private $_olimpicList;

    public function __construct($config = [])
    {
        $this->_olimpicList = new OlimpicList();
        parent::__construct($config);
    }

    public static function tableName()
    {
        return 'olimpic';
    }

    public static function create(OlympicCreateForm $form)
    {
        $olympic = new static();
        $olympic->name = $form->name;
        $olympic->status = $form->status;
        $olympic->managerId = $form->managerId;
        return $olympic;
    }

    public function edit(OlympicEditForm $form)
    {
        $this->name = $form->name;
        $this->status = $form->status;
        $this->managerId = $form->managerId;

    }

    public function getOlympicOneLast() {
        return $this->_olimpicList->olympicRelation($this->id)->orderBy(['year' => SORT_DESC])->one();
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'name' => 'Полное название мероприятия',
            'status' => 'Статус',
            'managerId'=> 'Ответственное лицо за олимпиаду',
        ];
    }

    public static function labels(): array
    {
        $olympic = new static();
        return $olympic->attributeLabels();
    }

    public static function find(): OlimpicQuery
    {
        return new OlimpicQuery(static::class);
    }

}