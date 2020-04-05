<?php


namespace modules\dictionary\helpers;
use modules\dictionary\models\DictIndividualAchievementDocument;

class DictIndividualAchievementDocumentHelper
{
    public static function listDocument($id) {
        return DictIndividualAchievementDocument::find()->select('document_type_id')->individualAchievementId($id)->column();
    }

}