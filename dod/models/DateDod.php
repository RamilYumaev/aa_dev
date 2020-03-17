<?php

namespace dod\models;

use common\helpers\DateTimeCpuHelper;
use dod\forms\DateDodCreateForm;
use dod\forms\DateDodEditForm;
use dod\helpers\DateDodHelper;
use dod\models\queries\DateDodQuery;
use yii\db\ActiveRecord;

class DateDod extends ActiveRecord
{
    private $_dod;

    public function __construct($config = [])
    {
        $this->_dod = new Dod();
        parent::__construct($config);
    }

    public static function tableName()
    {
        return 'date_dod';
    }

    public static function create(DateDodCreateForm $form, $dod_id)
    {
        $dateDod = new static();
        $dateDod->date_time = $form->date_time;
        $dateDod->dod_id = $dod_id;
        $dateDod->text = $form->text;
        $dateDod->broadcast_link = $form->broadcast_link;
        $dateDod->type = $form->type;
        return $dateDod;
    }

    public function edit(DateDodEditForm $form, $dod_id)
    {
        $this->date_time = $form->date_time;
        $this->broadcast_link = $form->broadcast_link;
        $this->text = $form->text;
        $this->dod_id = $dod_id;
        $this->type = $form->type;
    }

    public function attributeLabels()
    {
        return [
            'date_time' => 'Дата и время',
            'broadcast_link'=>"Код вставки на трансляцию",
            'text' => "Текст",
            'type' => 'Форма проведения'
        ];
    }

    public function getDodOne() {
        return $this->_dod->dodRelation($this->dod_id)->one();
    }

    public function getDateStartString(): string
    {
        return  "Дата проведения: ". DateTimeCpuHelper::getDateChpu($this->date_time);
    }

    public function getTextString(): string
    {
        return  $this->text ?? "";
    }

    public function getTimeStartString(): string
    {
        return  "Время начала: ". DateTimeCpuHelper::getTimeChpu($this->date_time);
    }

    public function replaceLabelsFromSending() {
        return [
            $this->dodOne->name, // {название ДОД}
            DateTimeCpuHelper::getDateChpu($this->date_time). ' года в ' . DateTimeCpuHelper::getTimeChpu($this->date_time),
        ];
    }

    public function isTypeRemote() {
        return $this->type == DateDodHelper::TYPE_REMOTE;
    }

    public function isTypeRemoteEdu() {
        return $this->type == DateDodHelper::TYPE_REMOTE_EDU;
    }

    public function isTypeIntramuralLiveBroadcast() {
        return $this->type == DateDodHelper::TYPE_INTRAMURAL_LIVE_BROADCAST;
    }

    public function isTypeIntramural() {
        return $this->type == DateDodHelper::TYPE_INTRAMURAL;
    }

    public function isTypeHybrid() {
        return $this->type == DateDodHelper::TYPE_HYBRID;
    }

    public function isTypeWeb() {
        return $this->type == DateDodHelper::TYPE_WEB;
    }

    public static function labels(): array
    {
        $dateDod = new static();
        return $dateDod->attributeLabels();
    }

    public function isDateActual() {
        return  $this->date_time > date('Y-m-d H:i:s');
    }

    public function isDateToday() {
        return \Yii::$app->formatter->asDate($this->date_time,'php:Y-m-d') == date('Y-m-d');
    }

    public static function find(): DateDodQuery
    {
        return new DateDodQuery(static::class);
    }



}