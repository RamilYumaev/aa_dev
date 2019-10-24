<?php
<<<<<<< HEAD:backend/helpers/dictionary/CategoryDocHelper.php

namespace backend\helpers\dictionary;

use backend\models\dictionary\CategoryDoc;
=======
namespace olympic\helpers\dictionary;
use olympic\models\dictionary\CategoryDoc;
use supplyhog\ClipboardJs\ClipboardJsAsset;
>>>>>>> #10:olympic/helpers/dictionary/CategoryDocHelper.php
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