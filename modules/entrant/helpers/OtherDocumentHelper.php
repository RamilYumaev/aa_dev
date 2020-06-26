<?php
namespace modules\entrant\helpers;
use common\helpers\EduYearHelper;
use modules\dictionary\helpers\DictIncomingDocumentTypeHelper;
use modules\entrant\models\Agreement;
use modules\entrant\models\OtherDocument;
use yii\helpers\ArrayHelper;

class OtherDocumentHelper
{
    const TRANSLATION_PASSPORT = 1;
    const TRANSLATION_DOCUMENT_EDU = 2;
    const TRANSLATION_DOCUMENT_NAME = 3 ;
    const STATEMENT_TARGET = 4;

    public static function translationList() {
        return [self::TRANSLATION_PASSPORT  => "Перевод документа, удостворяющего личность",
            self::TRANSLATION_DOCUMENT_EDU  => "Перевод документа об образовании",
            self::TRANSLATION_DOCUMENT_NAME  => "Документ о смене ФИО",
            self::STATEMENT_TARGET => 'Согласие на заключение договора о целевом обучении'
        ];
    }

    public static function isExitsExemption($user_id, $category): bool
    {
        return OtherDocument::find()->andWhere(['user_id' => $user_id, 'exemption_id'=> $category])->exists();
    }

    public static function isExitsPatriot($user_id): bool
    {
        return OtherDocument::find()->andWhere(['user_id' => $user_id,'type'=> 43])->exists();
    }

    public static function isExitsMedicine($user_id): bool
    {
        return OtherDocument::find()->andWhere(['user_id' => $user_id,'type'=> DictIncomingDocumentTypeHelper::ID_MEDICINE])->exists();
    }

    public static function isExitsUpdateName($user_id): bool
    {
        return OtherDocument::find()->andWhere(['user_id' => $user_id,'type'=>[DictIncomingDocumentTypeHelper::ID_NAME_UPDATE,
            DictIncomingDocumentTypeHelper::ID_NAME_WEDDING, DictIncomingDocumentTypeHelper::ID_NAME_WEDDING_DOC]])->exists();
    }

    public static function preemptiveRightUser($user_id, $type_id) {
        return OtherDocument::find()->joinWith('preemptiveRights')->andWhere(['user_id' => $user_id, 'type_id' => $type_id,
            'type'=> DictIncomingDocumentTypeHelper::rangeType(DictIncomingDocumentTypeHelper::TYPE_OTHER)])
            ->all();
    }

    public static function preemptiveRightExits($user_id) {
        return OtherDocument::find()->joinWith('preemptiveRights')->andWhere(['user_id' => $user_id,
            'type'=> DictIncomingDocumentTypeHelper::rangeType(DictIncomingDocumentTypeHelper::TYPE_OTHER)])
            ->exists();
    }

    public static function preemptiveRightAll($user_id) {
        return OtherDocument::find()->joinWith('preemptiveRights')->andWhere(['user_id' => $user_id,
            'type'=> DictIncomingDocumentTypeHelper::rangeType(DictIncomingDocumentTypeHelper::TYPE_OTHER)])
            ->all();
    }

    public static function listPreemptiveRightUser($user_id){
        return ArrayHelper::map(self::preemptiveRightAll($user_id), 'id', function ($model) {
            return  $model->otherDocumentFull  ." (". $model->typeName .")";
        });
    }
}