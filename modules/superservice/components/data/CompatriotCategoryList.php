<?php
namespace modules\superservice\components\data;


use modules\superservice\components\DataXml;

class CompatriotCategoryList extends DataXml
{
    public function getNameTitle(): string
    {
       return 'Категория документа соотечественника';
    }
}