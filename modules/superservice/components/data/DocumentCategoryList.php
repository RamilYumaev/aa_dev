<?php
namespace modules\superservice\components\data;

use modules\superservice\components\DataXml;

class DocumentCategoryList extends DataXml
{
    public function getNameTitle(): string
    {
        return 'Категория документов';
    }
}