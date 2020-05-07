<?php


namespace modules\entrant\models;

use common\moderation\behaviors\ModerationBehavior;
use common\moderation\interfaces\YiiActiveRecordAndModeration;
use modules\entrant\forms\DocumentEducationForm;
use modules\entrant\forms\FIOLatinForm;

/**
 * This is the model class for table "{{%fio_latin}}".
 *
 * @property integer $id
 * @property integer $user_id
 * @property string $patronymic
 * @property string $surname
 * @property string $name
 **/

class FIOLatin  extends YiiActiveRecordAndModeration
{
    public function behaviors()
    {
        return ['moderation' => [
            'class' => ModerationBehavior::class,
            'attributes' => [
                'patronymic', 'surname', 'name',]
        ]];
    }

    public static function tableName()
    {
        return '{{%fio_latin}}';
    }

    public static  function create(FIOLatinForm $form) {
        $fio =  new static();
        $fio->data($form);
        return $fio;
    }

    public function data(FIOLatinForm $form)
    {
        $this->surname = $form->surname;
        $this->patronymic = $form->patronymic;
        $this->name = $form->name;
        $this->user_id = $form->user_id;
    }


    public function titleModeration(): string
    {
        return "ФИО на латинском";
    }

    public function attributeLabels()
    {
        return [
            'patronymic' => 'Отчество (на латинском)',
            'surname' => 'Фамилия (на латинском)',
            'name' =>'Имя (на латинском)',
        ];
    }

    public function moderationAttributes($value): array
    {
        return [
            'patronymic' => $value,
            'surname' => $value,
            'name' => $value,
        ];
    }

    public function dataArray()
    {
        return [
            'patronymic' => $this->patronymic,
            'surname' => $this->surname,
            'name' => $this->name,
        ];
    }
}