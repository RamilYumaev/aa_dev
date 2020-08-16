<?php

namespace common\auth\models;

use common\auth\forms\DeclinationFioForm;
use wapmorgan\yii2inflection\Inflector;
use yii\db\ActiveRecord;
use Yii;

class DeclinationFio extends ActiveRecord
{
    public static function tableName()
    {
        return 'declination_fio';
    }

    public static function defaultCreate($fio, $user_id)
    {
        $declination = new static();
        $declination->data($fio);
        $declination->user_id = $user_id;
        return $declination;
    }

    public function data($fio, $twoWordPatronymic = "")
    {
        $this->nominative = self::declinationFio($fio, Inflector::NOMINATIVE) . $twoWordPatronymic;
        $this->genitive = self::declinationFio($fio, Inflector::GENITIVE) . $twoWordPatronymic;
        $this->dative = self::declinationFio($fio, Inflector::DATIVE) . $twoWordPatronymic;
        $this->accusative = self::declinationFio($fio, Inflector::ACCUSATIVE) . $twoWordPatronymic;
        $this->ablative = self::declinationFio($fio, Inflector::ABLATIVE) . $twoWordPatronymic;
        $this->prepositional = self::declinationFio($fio, Inflector::PREPOSITIONAL) . $twoWordPatronymic;
    }

    public function edit(DeclinationFioForm $form)
    {
        $this->nominative = $form->nominative;
        $this->genitive = $form->genitive;
        $this->dative = $form->dative;
        $this->accusative = $form->accusative;
        $this->ablative = $form->ablative;
        $this->prepositional = $form->prepositional;
    }

    public static function declinationFio($fio, $case)
    {
        return Yii::$app->inflection->inflectName($fio, $case);
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'Юзер',
            'nominative' => 'И.п.',
            'genitive' => 'Р.п.',
            'dative' => 'Д.п.',
            'accusative' => 'В.п.',
            'ablative' => 'Т.п.',
            'prepositional' => 'П.п.',
        ];
    }

    public static function labels()
    {
        $declination = new static();
        return $declination->attributeLabels();

    }

}