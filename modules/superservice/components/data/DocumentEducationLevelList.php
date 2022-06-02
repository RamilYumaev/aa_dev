<?php
namespace modules\superservice\components\data;

use modules\superservice\components\DataXml;

class DocumentEducationLevelList extends DataXml
{
    public function getNameTitle(): string
    {
       return "Уровень образования";
    }
}