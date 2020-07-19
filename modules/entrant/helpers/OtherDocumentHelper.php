<?php
namespace modules\entrant\helpers;
use common\helpers\EduYearHelper;
use modules\dictionary\helpers\DictIncomingDocumentTypeHelper;
use modules\entrant\models\Agreement;
use modules\entrant\models\OtherDocument;
use yii\helpers\ArrayHelper;
use function GuzzleHttp\Promise\queue;

class OtherDocumentHelper
{
    const TRANSLATION_PASSPORT = 1;
    const TRANSLATION_DOCUMENT_EDU = 2;
    const TRANSLATION_DOCUMENT_NAME = 3 ;
    const STATEMENT_TARGET = 4;
    const STATEMENT_AGREE_TPGU = 5;
    const WITHOUT_APPENDIX = 6;

    public static function translationList() {
        return [self::TRANSLATION_PASSPORT  => "Перевод документа, удостоверяющего личность",
            self::TRANSLATION_DOCUMENT_EDU  => "Перевод документа об образовании",
            self::TRANSLATION_DOCUMENT_NAME  => "Документ о смене ФИО",
            self::STATEMENT_TARGET => 'Согласие на заключение договора о целевом обучении',
            self::STATEMENT_AGREE_TPGU => 'Заявление о разрешении на дистанционное заключение договора 
            об оказании платных образовательных услуг',
            self::WITHOUT_APPENDIX => 'Заявление о подачи документа об образовании без приложения (без обложки)',
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

    public static function isWithout($user_id): bool
    {
        return OtherDocument::find()->andWhere(['user_id' => $user_id,'without'=> 1])->exists();
    }


    public static function isExitsMedicine($user_id): bool
    {
        return OtherDocument::find()->andWhere(['user_id' => $user_id,'type'=> DictIncomingDocumentTypeHelper::ID_MEDICINE])->exists();
    }

    public static function isExitsUpdateName($user_id): bool
    {
        return OtherDocument::find()->andWhere(['user_id' => $user_id,'type'=>[DictIncomingDocumentTypeHelper::ID_NAME_UPDATE,
            DictIncomingDocumentTypeHelper::ID_NAME_WEDDING, DictIncomingDocumentTypeHelper::ID_NAME_WEDDING_DOC,
            DictIncomingDocumentTypeHelper::ID_NAME_BREAK_WEDDING]])->exists();
    }

    public static function preemptiveRightUser($user_id, $type_id) {
        return OtherDocument::find()->joinWith('preemptiveRights')->andWhere(['user_id' => $user_id, 'type_id' => $type_id,
            'type'=> DictIncomingDocumentTypeHelper::rangeType(DictIncomingDocumentTypeHelper::TYPE_OTHER)])
            ->all();
    }

    public static function preemptiveRightUserStatusCount($user_id, $type_id, $status = null) {
        $query = OtherDocument::find()->joinWith('preemptiveRights')
            ->andWhere(['user_id' => $user_id, 'type_id' => $type_id,
            'type'=> DictIncomingDocumentTypeHelper::rangeType(DictIncomingDocumentTypeHelper::TYPE_OTHER)]);
        if($status) {
            $query->andWhere(['statue_id' => $status]);
        }
        return $query ->count();
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