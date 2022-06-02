<?php
namespace modules\superservice\components\data;


use modules\superservice\components\DataXml;

class RadiationWorkCategoryList extends DataXml
{
    public function getNameTitle(): string
    {
       return 'Категория документа';
    }
}