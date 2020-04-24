<?php


namespace modules\entrant\models;

use dictionary\helpers\DictCountryHelper;
use modules\dictionary\helpers\DictForeignLanguageHelper;
use modules\dictionary\models\DictForeignLanguage;
use modules\entrant\forms\LanguageForm;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "{{%language}}".
 *
 * @property integer $id
 * @property integer $user_id
 * @property integer $language_id
 *
 **/

class Language extends ActiveRecord
{

    public static function tableName()
    {
        return '{{%language}}';
    }

    public static  function create(LanguageForm $form) {
        $language =  new static();
        $language->data($form);
        return $language;
    }

    public function data(LanguageForm $form) {
        $this->language_id = $form->language_id;
        $this->user_id = $form->user_id;
    }

    public function attributeLabels()
    {
        return [
            'language_id' =>"Иностранный язык",
        ];
    }

    public function getDictLanguage()
    {
        return  $this->hasOne(DictForeignLanguage::class, ['id'=>'language_id']);
    }


}