<?php


namespace modules\entrant\models;

use common\moderation\behaviors\ModerationBehavior;
use common\moderation\interfaces\YiiActiveRecordAndModeration;
use dictionary\helpers\DictCountryHelper;
use modules\entrant\forms\AddressForm;
use modules\entrant\forms\OtherDocumentForm;
use modules\entrant\forms\PassportDataForm;
use modules\entrant\helpers\AddressHelper;
use modules\entrant\helpers\DateFormatHelper;
use modules\dictionary\helpers\DictIncomingDocumentTypeHelper;
use yii\base\InvalidConfigException;

/**
 * This is the model class for table "{{%other_document}}".
 *
 * @property integer $id
 * @property integer $user_id
 * @property integer $type
 * @property string $note
 *
**/

class OtherDocument extends YiiActiveRecordAndModeration
{
    public function behaviors()
    {
        return ['moderation' => [
            'class' => ModerationBehavior::class,
            'attributes' => [ 'type', 'note']
        ]];
    }

    public static  function create(OtherDocumentForm $form) {
        $otherDocument =  new static();
        $otherDocument->data($form);
        return $otherDocument;
    }

    public function data(OtherDocumentForm $form)
    {
        $this->type = $form->type;
        $this->note = $form->note;
        $this->user_id = $form->user_id;
    }

    public static function tableName()
    {
        return "{{%other_document}}";
    }

    public function titleModeration(): string
    {
        return "Прочие документы";
    }

    public function getTypeName() {
        return DictIncomingDocumentTypeHelper::typeName([DictIncomingDocumentTypeHelper::TYPE_EDUCATION_PHOTO,
            DictIncomingDocumentTypeHelper::TYPE_EDUCATION_VUZ], $this->type);
    }

    public function moderationAttributes($value): array
    {
        return [
            'type' => DictIncomingDocumentTypeHelper::typeName([DictIncomingDocumentTypeHelper::TYPE_EDUCATION_PHOTO,
                DictIncomingDocumentTypeHelper::TYPE_EDUCATION_VUZ], $value),
            'note' => $value,
            ];
    }

    public function attributeLabels()
    {
        return [
            'type'=>'Тип документа',
            'note'=>'Примечание',
        ];
    }

}