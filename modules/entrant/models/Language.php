<?php


namespace modules\entrant\models;

use common\moderation\behaviors\ModerationBehavior;
use common\moderation\interfaces\YiiActiveRecordAndModeration;
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

class Language extends YiiActiveRecordAndModeration
{

    public function behaviors()
    {
        return ['moderation' => [
            'class' => ModerationBehavior::class,
            'attributes' => [ 'language_id']
        ]];
    }

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


    public function titleModeration(): string
    {
        return  "Иностранные языки";
    }

    public function moderationAttributes($value): array
    {
        return ['language_id'=> DictForeignLanguage::findOne($value)->name,];
    }
}