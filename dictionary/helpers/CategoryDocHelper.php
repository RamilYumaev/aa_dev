<?php

namespace dictionary\helpers;

use dictionary\models\CategoryDoc;
use supplyhog\ClipboardJs\ClipboardJsAsset;
use yii\helpers\ArrayHelper;

class CategoryDocHelper
{
    const TYPELINK = 1;
    const TYPEDOC = 2;

    public static function categoryDocTypeList(): array
    {
        return [
            self::TYPELINK => 'Для ссылок',
            self::TYPEDOC => 'Для документов'
        ];
    }

    public static function categoryDocType(): array
    {
        return [
            self::TYPELINK,
            self::TYPEDOC
        ];
    }

    public static function categoryDocTypeName($type_id): string
    {
        return ArrayHelper::getValue(self::categoryDocTypeList(), $type_id);
    }


}