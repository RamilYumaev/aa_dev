<?php
namespace backend\helpers\dictionary;
use backend\models\dictionary\CategoryDoc;
use yii\helpers\ArrayHelper;

class CategoryDocHelper
{
    public static function categoryDocTypeList(): array
    {
        return [
            CategoryDoc::TYPELINK => 'Для ссылок',
            CategoryDoc::TYPEDOC => 'Для документов'
        ];
    }

    public static function categoryDocType(): array
    {
        return [
            CategoryDoc::TYPELINK,
            CategoryDoc::TYPEDOC
        ];
    }

    public static function categoryDocTypeName($type_id): string
    {
        return ArrayHelper::getValue(self::categoryDocTypeList(), $type_id);
    }


}